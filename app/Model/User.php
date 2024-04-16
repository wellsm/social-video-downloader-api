<?php

declare(strict_types=1);

namespace App\Model;

use Carbon\Carbon;
use Core\Entities\UserEntity;
use Core\ValueObject\UserCodeValueObject;
use DateTime;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model implements UserEntity
{
    protected array $fillable = [
        'name',
        'code',
    ];

    protected array $casts = [
        'id'         => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* --------- UserEntity -------- */
    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): self
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    public function getCode(): UserCodeValueObject
    {
        return new UserCodeValueObject($this->attributes['code']);
    }

    public function setCode(UserCodeValueObject $code): self
    {
        $this->attributes['code'] = (string) $code;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->attributes['updated_at'];
    }

    /* --------- Mutators -------- */
    public function getCodeAttribute(): string
    {
        return (string) $this->getCode();
    }

    public function setCodeAttribute(UserCodeValueObject $code): void
    {
        $this->setCode($code);
    }
}
