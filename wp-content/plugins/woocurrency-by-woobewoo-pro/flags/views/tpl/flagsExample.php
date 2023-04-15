                    <?php echo htmlWcu::selectboximage("{$this->dbPrefix}[flag][]", array(
                        'value' => 'USD',
                        'data-def' => 'USD',
                        'options' => $this->flagsList,
                        'data_img' => $this->flagsList,
                        'attrs' => 'disabled class="wcuFlagsSelectBox"',
                        ))?>
