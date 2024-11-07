<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\DesignPattern\Factory;

use App\Models\Coupon;

class CouponFactory implements CouponFactoryInterface
{
    public function getAddCouponPage()
    {
        // Return the view for adding a new coupon
        return view('BackEnd.Coupon.add');
    }

    public function createCoupon(array $data): Coupon
    {
        $coupon = new Coupon();
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_type = $data['coupon_type'];
        $coupon->coupon_value = $data['coupon_value'];
        $coupon->cart_min_value = $data['cart_min_value'];
        $coupon->expired_on = $data['expired_on'];
        $coupon->coupon_status = $data['coupon_status'];
        $coupon->added_on = $data['added_on'];

        $coupon->save();

        return $coupon;
    }

    public function updateCoupon(int $couponId, array $data): Coupon
    {
        $coupon = Coupon::find($couponId);
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_type = $data['coupon_type'];
        $coupon->coupon_value = $data['coupon_value'];
        $coupon->cart_min_value = $data['cart_min_value'];
        $coupon->expired_on = $data['expired_on'] ?? $coupon->expired_on;
        $coupon->coupon_status = $data['coupon_status'] ?? $coupon->coupon_status;
        $coupon->added_on = $data['added_on'] ?? $coupon->added_on;

        $coupon->save();

        return $coupon;
    }

    public function activateCoupon(int $couponId): Coupon
    {
        $coupon = Coupon::find($couponId);
        $coupon->coupon_status = 1;
        $coupon->save();

        return $coupon;
    }

    public function deactivateCoupon(int $couponId): Coupon
    {
        $coupon = Coupon::find($couponId);
        $coupon->coupon_status = 0;
        $coupon->save();

        return $coupon;
    }

    public function deleteCoupon(int $couponId): void
    {
        $coupon = Coupon::find($couponId);
        $coupon->delete();
    }

    public function getAllCoupons()
    {
        return Coupon::all();
    }
}