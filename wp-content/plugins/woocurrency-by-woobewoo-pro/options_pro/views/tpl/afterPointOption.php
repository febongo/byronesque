<?php
$disabled = empty($this->params) ? 'disabled="disabled" ' : '';
echo htmlWcu::selectbox("{$this->dbPrefix}[after_point][]", array(
	'value' => isset($this->params['after_point']) ? $this->params['after_point'] : $this->defAfterPoint,
	'options' => $this->options,
	'attrs' => $disabled . 'class="wcuAfterPoint wcuHidden"',
	'data-def' => $this->defAfterPoint,
))?>