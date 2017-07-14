{addJsDef cinturones=$atributos['Cinturón']}
{addJsDef pasadores=$atributos['Pasador']}
{addJsDef combinaciones=$combinaciones}
{addJsDef producto=$producto}
<div id="southingcustomizer" class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>{l s='Personalizador'}</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div id="slide-cinturones">
			{foreach from=$atributos['Cinturón'] key=key item=cinturon}
				<div><img src="{$cinturon.img}" /></div>
			{/foreach}
			</div>
		</div>
	</div>
	<div class="row" id="fila-pasadores">
		<div class="col-xs-12">
			<div id="slide-pasadores">
				{foreach from=$atributos['Pasador'] key=key item=pasador}
					<div><img src="{$pasador.img}" /></div>
				{/foreach}
			</div>
		</div>
	</div>
	<div class="row" id="fila-seleccion">
		<div class="col-md-8">
			<p class="titulo-seleccion">{l s='Selección'}:</p>
			<span id="titulo-cinturon">{l s='Cinturón'}:</span> <span id="cinturon-seleccionado">{$atributos['Cinturón'][0]['nombre']}</span><br /><span id="titulo-pasador">{l s='Pasador'}:</span> <span id="pasador-seleccionado">{$atributos['Pasador'][0]['nombre']}</span>
		</div>
		<div class="col-md-4 text-right">
			{assign var="nombre_combinacion" value="{$atributos['Cinturón'][0]['nombre_comb']}, {$atributos['Pasador'][0]['nombre_comb']}"}
			<button id="comprar-selección" class="btn btn-default">{l s='Añadir al carrito'} - <span id="precio-combinacion">{$combinaciones[$nombre_combinacion]['precio']}</span>€</button>
		</div>
	</div>
	<input type="hidden" name="combinacion" id="combinacion" value="{$atributos['Cinturón'][0]['nombre_comb']}, {$atributos['Pasador'][0]['nombre_comb']}" />
</div>