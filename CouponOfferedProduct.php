<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace CouponOfferedProduct;

use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Model\CouponQuery;
use Thelia\Module\BaseModule;

class CouponOfferedProduct extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'couponofferedproduct';

    const OFFERED_PRODUCT_SERVICE_ID = 'coupon.type.offered_product';

    public static function isCouponTypeOfferedProduct($couponCode)
    {
        $coupon = CouponQuery::create()->findOneByCode($couponCode);

        if ($coupon !== null && $coupon->getType() == self::OFFERED_PRODUCT_SERVICE_ID) {
            return true;
        }

        return false;
    }

    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR . ucfirst(self::getModuleCode()). "/I18n/*"])
            ->autowire(true)
            ->autoconfigure(true);
    }
}
