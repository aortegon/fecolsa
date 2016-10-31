<?php

function html_attr($attr, $html = null) {
    if (is_array($attr) === false) :
        return $attr;
    endif;
    $size = sizeof($attr);
    if ($size === 0) :
        return null;
    endif;
    foreach ($attr as $key => $value) :
        $html .= $key . '="' . $value . '" ';
    endforeach;
    return $html;
}

function html_input($attr, $html = null) {
    def($attr['type'], 'text');
    def($attr['class'], 'form-control');
    def($attr['name'], $attr['id']);
    def($attr['value'], def($_REQUEST[$attr['id']]));
    $html .= '<input ' . html_attr($attr) . ' />';
    $html .= '<div class="error-message" id="error_' . $attr['id'] . '"></div>';
    return $html;
}

function html_textarea($attr, $html = null) {
    def($attr['class'], 'form-control');
    def($attr['name'], $attr['id']);
    def($attr['value'], def($_REQUEST[$attr['id']]));
    $html .= '<textarea ' . html_attr($attr) . '>' . $attr['value'] . '</textarea>';
    $html .= '<div class="error-message" id="error_' . $attr['id'] . '"></div>';
    return $html;
}

function html_select($attr, $options = array(), $html = null) {
    def($attr['class'], 'form-control');
    def($attr['name'], $attr['id']);
    def($attr['value'], def($_REQUEST[$attr['id']]));
    def($attr['placeholder'], 'Seleccionar');
    $html .= '<select ' . html_attr($attr) . '>';
    $html .= '<option value="">' . $attr['placeholder'] . '</option>';
    $size = sizeof($options);
    for ($o = 0; $o < $size; $o++) :
        $keys = array_keys($options[$o]);
        $selected = (string) $attr['value'] === (string) $options[$o][$keys[0]] ? 'selected="selected"' : null;
        $html .= '<option value="' . $options[$o][$keys[0]] . '" ' . $selected . '>' . $options[$o][$keys[1]] . '</option>';
    endfor;
    $html .= '</select>';
    $html .= '<div class="error-message" id="error_' . $attr['id'] . '"></div>';
    return $html;
}

function html_select_multiple($attr, $options = array(), $html = null) {
    def($attr['class'], 'form-control');
    def($attr['name'], $attr['id']);
    def($attr['value'], def($_REQUEST[$attr['id']]));
    $html .= '<select multiple ' . html_attr($attr) . '>';
    $html .= '<optgroup label="Selección Multiple">';
    $size = sizeof($options);
    for ($o = 0; $o < $size; $o++) :
        $keys = array_keys($options[$o]);
        $selected = (string) $attr['value'] === (string) $options[$o][$keys[0]] ? 'selected="selected"' : null;
        $html .= '<option value="' . $options[$o][$keys[0]] . '" ' . $selected . '>' . $options[$o][$keys[1]] . '</option>';
    endfor;
    $html .= ' </optgroup>';
    $html .= '</select>';
    $html .= '<div class="error-message" id="error_' . $attr['id'] . '"></div>';
    return $html;
}

function html_info($attr, $text, $html = null) {
    $attr['class'] = isset($attr['class']) === true ? $attr['class'] : 'info';
    def($attr['value'], def($_REQUEST[$attr['id']]));
    $html .= '<div class="' . $attr['class'] . '" data-id="' . $attr['id'] . '">' . $text . '</div>';
    $html .= '<input type="hidden" name="' . $attr['id'] . '" id="' . $attr['id'] . '" value="' . $attr['value'] . '" />';
    return $html;
}

function html_calendar($attr, $years = array(), $months = array(), $days = array(), $html = null) {
    def($attr['name'], $attr['id']);
    def($attr['value'], def($_REQUEST[$attr['id']]));
    //def($attr['required'], null);
    if ($attr['value'] === null) {
        $years['value'] = null;
        $months['value'] = null;
        $days['value'] = null;
    } else {
        $value = explode('-', $attr['value']);
        $years['value'] = $value[0];
        $months['value'] = $value[1];
        $days['value'] = $value[2];
    }
    $html .= '<table cellspacing="0" celppadding="0">';
    $html .= '<tr>';
    if($attr['ind_years'] == 1):
        $html .= '<td>' . html_calendar_years2($attr, $years) . '</td>';
    else:
        $html .= '<td>' . html_calendar_years($attr, $years) . '</td>';
    endif;
    $html .= '<td>' . html_calendar_months($attr, $months) . '</td>';
    $html .= '<td>' . html_calendar_days($attr, $years, $months, $days) . '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    unset($attr['article']);
    $html .= '<input type="hidden" ' . html_attr($attr) . ' />';
    $html .= '<div class="error-message" id="error_' . $attr['id'] . '"></div>';
    return $html;
}

function html_calendar_years($attr, $years, $html = null) {
    def($years['ini'], date('Y'));
    def($years['fin'], date('Y') - 80);
    $html .= '<select id="y_' . $attr['id'] . '" calendar="' . $attr['id'] . '" year article="' . $attr['article'] . '" ' . $attr['required'] . '>';
    $html .= '<option value="">Año</option>';
    for ($y = $years['ini']; $y >= $years['fin']; $y--) :
        $selected = $y === (int) $years['value'] ? 'selected="selected"' : null;
        $html .= '<option value="' . $y . '" ' . $selected . '>' . $y . '</option>';
    endfor;
    $html .= '</select>';
    return $html;
}

function html_calendar_years2($attr, $years, $html = null) {
    def($years['ini'], date('Y') + 2);
    def($years['fin'], date('Y'));
    $html .= '<select id="y_' . $attr['id'] . '" calendar="' . $attr['id'] . '" year article="' . $attr['article'] . '" ' . $attr['required'] . '>';
    $html .= '<option value="">Año</option>';
    for ($y = $years['ini']; $y >= $years['fin']; $y--) :
        $selected = $y === (int) $years['value'] ? 'selected="selected"' : null;
        $html .= '<option value="' . $y . '" ' . $selected . '>' . $y . '</option>';
    endfor;
    $html .= '</select>';
    return $html;
}

function html_calendar_months($attr, $months, $html = null) {
    def($months['ini'], 1);
    def($months['fin'], 12);
    $html .= '<select id="m_' . $attr['id'] . '" calendar="' . $attr['id'] . '" month article="' . $attr['article'] . '" ' . $attr['required'] . '>';
    $html .= '<option value="">Mes</option>';
    for ($m = $months['ini']; $m <= $months['fin']; $m++) :
        $month = str_pad($m, 2, '0', STR_PAD_LEFT);
        $selected = $m === (int) $months['value'] ? 'selected="selected"' : null;
        $html .= '<option value="' . $month . '" ' . $selected . '>' . get_month($m) . '</option>';
    endfor;
    $html .= '</select>';
    return $html;
}

function html_calendar_days($attr, $years, $months, $days, $html = null) {
    def($days['ini'], 1);
    def($days['fin'], get_monthdays($years['value'], $months['value']));
    $html .= '<select id="d_' . $attr['id'] . '" calendar="' . $attr['id'] . '" article="' . $attr['article'] . '" ' . $attr['required'] . '>';
    $html .= '<option value="">Día</option>';
    for ($d = 1; $d <= 31; $d++) :
        $day = str_pad($d, 2, '0', STR_PAD_LEFT);
        $selected = $d === (int) $days['value'] ? 'selected="selected"' : null;
        $html .= '<option value="' . $day . '" ' . $selected . '>' . $day . '</option>';
    endfor;
    $html .= '</select>';
    return $html;
}

function html_upload($attr, $html = null) {
    def($attr['name'], $attr['id']);
    def($attr['href'], null);
    def($attr['preview'], true);
    $value = def($_REQUEST[$attr['id']], null);
    //def($attr['required'], null);
    $html .= '<table class="upload">';
    $html .= '<tr>';
    $html .= '<td style="min-width:130px;">';
    $html .= '<label>Subir Archivo <span class="glyphicon glyphicon-upload"></span>';
    $html .= '<span>';
    $html .= '<input type="file" ' . html_attr($attr) . ' />';
    $html .= '</span>';
    $html .= '</label>';
    $html .= '</td>';
    $html .= '<td width="100%">';
    $html .= '<input class="file-disabled" type="text" name="u_' . $attr['id'] . '" id="u_' . $attr['id'] . '" readonly="readonly" article="' . $attr['article'] . '" value="' . $value . '" />';
    $html .= '<div class="error-message" id="error_' . $attr['id'] . '"></div>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    if ($value !== null && $attr['preview'] === true) :
        $html .= '<a href="' . $attr['href'] . '" target="blank">[ ver archivo ]</a>';
    endif;
    return $html;
}

function html_subtitle($text, $link = null) {
    $html .= '<div class="subtitle-section">';
    $html .= '<table>';
    $html .= '<tr>';
    $html .= '<td class="text"><span>' . $text . '</span></td>';
    if ($link !== null) :
        $html .= '<td class="link"><a>' . $link . '</a></td>';
    endif;
    $html .= '</tr>';
    $html .= '</table>';
    $html .= '</div>';
    return $html;
}