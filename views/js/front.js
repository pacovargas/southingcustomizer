/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
$(function(){
	$("#slide-cinturones").slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: true,
	});

	$('#slide-pasadores').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: true,
	});

	$("#id-cinturon").val(cinturones[0]['id']);
	$("#id-pasador").val(pasadores[0]['id']);

	$("#slide-cinturones button.slick-arrow, #slide-pasadores button.slick-arrow").click(function(event) {
		var keyCinturon = $("#slide-cinturones .slick-current").attr('data-slick-index');
		var keyPasador = $("#slide-pasadores .slick-current").attr('data-slick-index');
		$("#cinturon-seleccionado").html(cinturones[keyCinturon].nombre);
		$("#pasador-seleccionado").html(pasadores[keyPasador].nombre);
		var precio = parseFloat(cinturones[keyCinturon]['precio']) + parseFloat(pasadores[keyPasador]['precio']);
		$("#precio-combinacion").html(precio.toFixed(2));
		$("#id-cinturon").val(cinturones[keyCinturon]['id']);
		$("#id-pasador").val(pasadores[keyPasador]['id']);
	});

	$("#comprar-selección").click(function(event) {
		var idCinturon = $("#id-cinturon").val();
		var idPasador = $("#id-pasador").val();
		ajaxCart.add(idCinturon, null, false, false, 1, false);
		ajaxCart.add(idPasador, null, false, false, 1, false);
	});
});