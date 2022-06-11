<?php

namespace App\Providers;

use Closure;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\ServiceProvider;

class PersonUserProvider extends EloquentUserProvider
{

    private $foreign_model;

    public function __construct(HasherContract $hasher, $model, $foreign_model)
    {
        parent::__construct($hasher, $model);
        $this->foreign_model = $foreign_model;
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (
            empty($credentials) ||
            (count($credentials) === 1 &&
                str_contains($this->firstCredentialKey($credentials), 'password'))
        ) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (str_contains($key, 'password')) {
                continue;
            }

            //Change to reference Person model
            if (is_array($value) || $value instanceof Arrayable) {
                $query->with([$this->foreign_model => function ($query) use ($key, $value) {
                    $query->whereIn($key, $value);
                }]);
            } elseif ($value instanceof Closure) {
                $value($query);
            } else {
                $query->with([$this->foreign_model => function ($query) use ($key, $value) {
                    $query->where($key, $value);
                }]);
            }
        }

        return $query->first();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
