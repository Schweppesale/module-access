<?php
namespace Schweppesale\Access\Domain\Entities;

use Schweppesale\Media\Domain\Entities\Image;
use Doctrine\ORM\Mapping as ORM;
use Watson\Validating\ValidationException;

/**
 * @todo    deprecated - remove this
 *
 * Class CompanyLogo
 *
 * @package Modules\Peggy\Entities
 * @ORM\Entity
 * @ORM\Table(name="images")
 */
class CompanyLogo extends Image
{

    /**
     * @const int
     */
    const MAX_HEIGHT = 25;

    /**
     * @const int
     */
    const MAX_WIDTH = 25;

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        if ($height > self::MAX_HEIGHT) {
            throw new ValidationException('Height can not exceed 25');
        }
        return parent::setHeight($height);
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        if ($width > self::MAX_WIDTH) {
            throw new ValidationException('Width can not exceed 25');
        }
        return parent::setWidth($width);
    }
}
