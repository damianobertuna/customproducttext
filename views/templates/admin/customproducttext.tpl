<div id="reviews-data-container" class="panel">
	<h3>
		<i class="icon icon-credit-card"></i> {l s='Add your custom text' mod='customproducttext'}
	</h3>
  <div><textarea class="" id="customText" rows="4" cols="50">{$customText}</textarea></div>
  <div><button type="button" id="saveCustomText" class="btn btn-default" data-dismiss="modal"> {l s='Save' mod='customproducttext'}</button></div>
  <div id="returnStatus" class="text-white" style=""></div>
</div>

{literal}
<script>
	var idProduct = "{/literal}{$idProduct|escape:'htmlall':'UTF-8'}{literal}";
	var secureToken = "{/literal}{$secureToken|escape:'htmlall':'UTF-8'}{literal}";    
    var idEmployee = "{/literal}{$idEmployee|escape:'htmlall':'UTF-8'}{literal}";
    var settingUpdated = "{/literal}{l s='Setting updated' mod='customproducttext'}{literal}";
	var updateFailed = "{/literal}{l s='Update failed' mod='customproducttext'}{literal}";
</script>
{/literal}