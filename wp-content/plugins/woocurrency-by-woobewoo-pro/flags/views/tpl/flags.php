                    <?php echo htmlWcu::selectboximage("{$this->dbPrefix}[flag][]", array(
                        'value' => !empty($this->params['flag']) ? $this->params['flag'] : $this->params['name'],
                        'data-def' => $this->params['name'],
                        'options' => $this->flagsList,
                        'data_img' => $this->flagsList,
                        'attrs' => 'class="wcuFlagsSelectBox"',
                        ))?>
