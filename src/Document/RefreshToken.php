<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;
use Gesdinet\JWTRefreshTokenBundle\Document\RefreshToken as BaseRefreshToken;

#[ODM\Document(collection: 'refresh_tokens')]
class RefreshToken extends BaseRefreshToken
{
    #[ODM\Field(type: 'date')]
    #[ODM\Index(expireAfterSeconds: 0)]
    protected ?\DateTimeInterface $valid;
}
