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

            if (is_array($value) || $value instanceof Arrayable) {
                // Search based on email column under 'person' relation
                $query->whereHas($this->foreign_model, function($q) use ($key, $value) {
                    $q->where($key, $value);
                })->with($this->foreign_model);
            } elseif ($value instanceof Closure) {
                $value($query);
            } else {
                // Search based on email column under 'person' relation
                $query->whereHas($this->foreign_model, function($q) use ($key, $value) {
                    $q->where($key, $value);
                })->with($this->foreign_model);
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
