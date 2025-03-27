<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomLayout extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'custom_layouts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'icon_som',
        'icon_mensagem',
        'icon_coletavel',
        'agente_afiliado',


        'texto_suporte',
        'descricao_suporte',


        'notificacao_titulo_1',
        'notificacao_titulo_2',
        'notificacao_titulo_3',
        'notificacao_titulo_4',
        'notificacao_titulo_5',
        'notificacao_descricao_1',
        'notificacao_descricao_2',
        'notificacao_descricao_3',
        'notificacao_descricao_4',
        'notificacao_descricao_5',
        'notificacao_icon_1',
        'notificacao_icon_2',
        'notificacao_icon_3',
        'notificacao_icon_4',
        'notificacao_icon_5',


        'noticia_titulo_1',
        'noticia_titulo_2',
        'noticia_titulo_3',
        'noticia_titulo_4',
        'noticia_titulo_5',

        'noticia_descricao_1',
        'noticia_descricao_2',
        'noticia_descricao_3',
        'noticia_descricao_4',
        'noticia_descricao_5',

        'noticia_icon_1',
        'noticia_icon_2',
        'noticia_icon_3',
        'noticia_icon_4',
        'noticia_icon_5',


        'link_app',
        'link_suporte', 
        'suporte_imagem',
        'link_lincenca',
        'link_footer_imagen1',
        'link_footer_imagen2',
        'link_footer_imagen3', 
        'mensagem_home',
        'sobre_fotter', 
        'navbar_img_login', 
        'menu_cell_inicio',
        'menu_cell_promocao',
        'menu_cell_agente',
        'menu_cell_suporte',
        'menu_cell_perfil',
        'menu_cell_deposito',

        'footer_imagen1',
        'footer_imagen2',
        'footer_imagen3',

        'footer_telegram',
        'footer_facebook',
        'footer_whatsapp',
        'footer_instagram',
        'footer_mais18',
        'image_pop_up3',
        'font_family_default',
        'primary_color',
        'primary_opacity_color',
        'secundary_color',
        'gray_dark_color',
        'gray_light_color',
        'gray_medium_color',
        'gray_over_color',
        'title_color',
        'text_color',
        'sub_text_color',
        'placeholder_color',
        'background_color',
        'image_pop_up1',
        'image_pop_up2',
        'image_agente',
        'image_pedente',
        'image_eventos',
        'banner_deposito1',
        'banner_deposito2',
        'banner_licença',
        'banner_jackpot',
        'background_base',
        'background_base_dark',

        'input_primary',
        'input_primary_dark',

        'carousel_banners',
        'carousel_banners_dark',

        'sidebar_color',
        'sidebar_color_dark',

        'navtop_color',
        'navtop_color_dark',

        'side_menu',
        'side_menu_dark',

        'footer_color',
        'footer_color_dark',

        'card_color',
        'card_color_dark',

        'border_radius',
        'custom_css',
        'custom_js',
        'custom_header',
        'custom_body',

        /// redes sociais
        'instagram',
        'facebook',
        'telegram',
        'twitter',
        'whastapp',
        'youtube',
    ];

}
