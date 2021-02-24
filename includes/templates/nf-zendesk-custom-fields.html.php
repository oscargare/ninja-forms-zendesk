<?php
/**
 * Zendesk custom fields template. Option repiter template.
 *
 * @see https://developer.ninjaforms.com/codex/option-repeater/
 * @package NF_Zendesk
 */

defined( 'ABSPATH' ) || exit;
?>

<script type="text/template" id="tmpl-nf-zendesk-custom-field-row">
<div>
	<span class="dashicons dashicons-menu handle"></span>
</div>
<div>
	<input type="text" class="setting" value="{{{ data.field_id }}}" data-id="field_id">
</div>
<div class="has-merge-tags">
	<input type="text" class="setting" value="{{{ data.value }}}" data-id="value">
	<span class="dashicons dashicons-list-view merge-tags"></span>
</div>
<div>
	<span class="dashicons dashicons-dismiss nf-delete"></span>
</div>
</script>
