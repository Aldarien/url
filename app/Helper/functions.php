<?php
function url($path = '', $variables = null) {
	return App\Contract\URL::url($path, $variables);
}
function baseUrl() {
    return url();
}
?>