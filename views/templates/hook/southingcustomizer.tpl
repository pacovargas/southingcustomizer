{addJsDef cinturones=$productos['cinturones']}
{addJsDef pasadores=$productos['pasadores']}
<div id="southingcustomizer" class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>{l s='Personalizador'}</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div id="slide-cinturones">
			{foreach from=$productos['cinturones'] key=key item=cinturon}
				<div><img src="{$cinturon.imagen}" /></div>
			{/foreach}
			</div>
		</div>
	</div>
	<div class="row" id="fila-pasadores">
		<div class="col-xs-12">
			<div id="slide-pasadores">
				{foreach from=$productos['pasadores'] key=key item=pasador}
					<div><img src="{$pasador.imagen}" /></div>
				{/foreach}
			</div>
		</div>
	</div>
	<div class="row" id="fila-seleccion">
		<div class="col-md-8">
			<p class="titulo-seleccion">{l s='Selección'}:</p>
			<span id="titulo-cinturon">{l s='Cinturón'}:</span> <span id="cinturon-seleccionado">{$productos['cinturones'][0]['nombre']}</span><br /><span id="titulo-pasador">{l s='Pasador'}:</span> <span id="pasador-seleccionado">{$productos['pasadores'][0]['nombre']}</span>
		</div>
		<div class="col-md-4 text-right">
			{assign var="nombre_combinacion" value="{$atributos['Cinturón'][0]['nombre_comb']}, {$atributos['Pasador'][0]['nombre_comb']}"}
			{assign var="precio" value=$productos['cinturones'][0]['precio'] + $productos['pasadores'][0]['precio']}
			<button id="comprar-selección" class="btn btn-default">{l s='Añadir al carrito'} - <span id="precio-combinacion">{$precio}</span>€</button>
		</div>
	</div>
	<input type="hidden" name="id-cinturon" id="id-cinturon" value="">
	<input type="hidden" name="id-pasador" id="id-pasador" value="">
</div>