<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tall\Tenant\Actions\ForgetCurrentTenantAction;
use Tall\Tenant\Actions\MakeCurrentTenantAction;

use App\Models\User;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tall\Orm\Models\AbstractModel;
use Tall\Sluggable\SlugOptions;
use Tall\Sluggable\HasSlug;
use Tall\Tenant\Contracts\ITenant;
use Tall\Tenant\TenantCollection;

class Tenant extends AbstractModel implements ITenant
{
    use HasFactory, HasSlug, SoftDeletes;
    
    protected $guarded = ['id'];

    //protected $with = ['address'];

    
    public $incrementing = false;

    protected $keyType = "string";


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    protected function slugTo()
    {
        return "slug";
    }

    protected function slugFrom()
    {
        return 'name';
    }

    public function isUser()
    {
        return true;
    }

    public function getSlugOptions()
    {
        if (is_string($this->slugTo())) {
            return SlugOptions::create()
                ->generateSlugsFrom($this->slugFrom())
                ->saveSlugsTo($this->slugTo());
        }
    }
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function makeCurrent(): self
    {

        if ($this->isCurrent()) {
            return $this;
        }

        static::forgetCurrent();
        $this
            ->getMultitenancyActionClass('make_tenant_current_action', MakeCurrentTenantAction::class)
            ->execute($this);

        return $this;
    }

    public function forget(): self
    {
        $this
            ->getMultitenancyActionClass('forget_current_tenant_action', ForgetCurrentTenantAction::class)
            ->execute($this);

        return $this;
    }

    public static function current()
    {
        $containerKey = config('tenant.current_tenant_container_key');

        if (!app()->has($containerKey)) {
            return null;
        }

        return app($containerKey);
    }

    public static function checkCurrent(): bool
    {
        return static::current() !== null;
    }

    public function isCurrent(): bool
    {
        return optional(static::current())->id === $this->id;
    }

    public static function forgetCurrent()
    {
        $currentTenant = static::current();

        if (is_null($currentTenant)) {
            return null;
        }

        $currentTenant->forget();

        return $currentTenant;
    }

    public function getDatabaseName()
    {
        return $this->database;
    }

    public function newCollection(array $models = [])
    {

        return new TenantCollection($models);
    }

    public function execute(callable $callable)
    {
        $originalCurrentTenant = Tenant::current();

        $this->makeCurrent();

        return tap($callable($this), static function () use ($originalCurrentTenant) {
            $originalCurrentTenant
                ? $originalCurrentTenant->makeCurrent()
                : Tenant::forgetCurrent();
        });
    }

}
