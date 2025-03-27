<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'software_name',
    'software_description',
    'software_favicon',
    'software_logo_white',
    'software_logo_black',
    'software_background',
    'currency_code',
    'decimal_format',
    'currency_position',
    'revshare_percentage',
    'ngr_percent',
    'soccer_percentage',
    'prefix',
    'storage',
    'initial_bonus',
    'min_deposit',
    'max_deposit',
    'min_withdrawal',
    'max_withdrawal',
    'rollover',
    'rollover_deposit',
    'suitpay_is_enable',
    'stripe_is_enable',
    'bspay_is_enable',
    'sharkpay_is_enable',
    'digito_is_enable',
    'ezzepay_is_enable',
    'saque',
    'turn_on_football',
    'revshare_reverse',
    'bonus_vip',
    'activate_vip_bonus',
    'updated_at',
    'maintenance_mode',
    'withdrawal_limit',
    'withdrawal_period',
    'disable_spin',
    'perc_sub_lv1',
    'perc_sub_lv2',
    'perc_sub_lv3',
    'disable_rollover',
    'rollover_protection',
    'cpa_baseline',
    'cpa_value',
    'cpa_percentage_baseline',
    'cpa_percentage',
    'mercadopago_is_enable',
    'digitopay_is_enable',
    'default_gateway',
    'trunk_baseline',
    'trunk_aposta',
    'trunk_valor',
    ];

    protected $hidden = ['updated_at'];
}
