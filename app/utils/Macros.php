<?php namespace App\Util;

/**
 * -------------------------------------
 *              STRING MACROS
 * -------------------------------------
 *
 */
\Str::macro('hes', function ($str) {
    $find    = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
    $replace = array(
        "&aacute;",
        "&eacute;",
        "&iacute;",
        "&oacute;",
        "&uacute;",
        "&ntilde;",
        "&Aacute;",
        "&Eacute;",
        "&Iacute;",
        "&Oacute;",
        "&Uacute;",
        "&Ntilde;",
    );

    return str_replace($find, $replace, $str);
    //return htmlentities($str, ENT_QUOTES, "UTF-8");
});

/**
 * -------------------------------------
 *              FORMS MACROS
 * -------------------------------------
 *
 */
\Form::macro('radio_scale', function ($data = array(), $max_number = 0, $order = 'ASC', $options = array()) {
    $output = '';
    $header = '';
    $body   = '';
    $name   = array_get($data, 'name', 'default');
    $header .= '<div class="table-responsive hidden-xs hidden-sm"><table class="table table-hover table-condensed"><thead class="text-center"><tr><td></td>';
    for ($i = 1; $i <= $max_number; $i++) {
        $header .= '<td>' . $i . '</td>';
    }
    $header .= '</tr></thead><tbody class="text-center"><tr><td class="text-left">' . $name . '</td>';
    switch (\Str::upper($order)) {
        case 'ASC':
            for ($i = 1; $i <= $max_number; $i++) {
                $body .= '<td>' . \Form::radio('name', $i, false, $options) . '</td>';
            }
            break;
        case 'DESC':
            for ($i = $max_number; $i >= 1; $i--) {
                $body .= '<td>' . \Form::radio('name', $i, false, array('required' => 'required')) . '</td>';
            }
            break;
    }
    $body .= '</tr>
</tbody>
</table>';
    echo $header . $body;
});
\Form::macro('bsRadioForm', function ($name, $data = array(), $old = null, $options = array()) {
    $out   = '';
    $count = 0;
    foreach ($data as $key => $value) {
        ($old == $key) ? $cheked = 'checked' : '';
        $out .= '<div class="radio">
              <label>
                <input type="radio" name="' . $name . '" id="' . $name . $count . '" value="' . $key . '" ' . $old . '>&nbsp;' . $value . '</label>
            </div>';
        $count++;
    }

    return $out;

});

\Form::macro('selectRange2', function ($name, $begin, $end, $selected = null, $options = array()) {

    $list  = ' <option></option> ';
    $range = array_combine($range = range($begin, $end), $range);

    foreach ($range as $key => $value) {
        $list .= " < option value = '$key' > $value</option > ";
    }

    $options = \HTML::attributes($options);
    unset($range);

    return '<select name = ' . e($name) . $options . '> ' . $list . '</select> ';
});

/**
 * -------------------------------------
 *              HTML MACROS
 * -------------------------------------
 *
 */

/**
 * GENERATE TABLE
 */
\HTML::macro('tableize', function ($name, $structure, $data, $headers = true, $options = array()) {

    $html = '';

    if ($headers) {
        $html .= '<table id="detailTable" name = ' . e($name) . ' ' . \HTML::attributes($options) . '>';
        $html .= '<thead class="text-center">';
        $html .= '<tr>';
        foreach ($structure as $title) {
            $html .= '<th>' . utf8_decode($title) . '</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
    }

    foreach ($data as $item) {
        $html .= '<tr>';
        foreach ($structure as $key => $value) {
            $html .= '<td>' . utf8_decode($item->$key) . '</td>';
        }
        $html .= '</tr>';
    }

    if ($headers) {
        $html .= '</tbody>';
        $html .= '</table>';
    }

    return $html;
});

/**
 * CREATE ALERT TYPE BOOTSTRAP
 */
\HTML::macro('create_alert', function ($data = array(), $options = array()) {

    if (!count($data) || $data === '' || $data == 0) {
        return;
    }
    if (!count($options) || $options === '' || $options == 0) {
        $options = null;
    }
    $title    = array_get($data, 'title', null);
    $subtitle = array_get($data, 'subtitle', null);
    $text     = array_get($data, 'text', null);
    $type     = array_get($data, 'type', null);
    switch ($type) {
        case 'danger':
            $type = 'alert-danger';
            break;
        case 'info':
            $type = 'alert-info';
            break;
        case 'success':
            $type = 'alert-success';
            break;
        case 'warning':
            $type = 'alert-warning';
            break;
        default:
            break;
    }
    $output = ' <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2"><div role = "alert" class="alert ' . $type . ' fade in"><button data-dismiss = "alert" class="close" type = "button"><i class="fa fa-times"></i></button>';
    $output .= isset($title) ? '<h4> ' . \Str::hes($title) . '</h4> ' : '';
    $output .= isset($subtitle) ? ' <h5>' . \Str::hes($subtitle) . ' </h5> ' : '';
    $output .= isset($text) ? ' <p>' . \Str::hes($text) . ' </p> ' : '';
    if (isset($options)) {
        $output .= ' <p>';
        foreach ($options as $option) {
            $output .= $option;
        }
        $output .= ' </p> ';
    }
    $output .= '<p class="clearfix"></div></div>';

    echo $output;
});

/**
 * BOOTSTRAP ALERT WITH AUTOMATIC HIDDEN JS
 */
\HTML::macro('alert', function ($type, $messages = array(), $head = null) {
    $message = '';
    foreach ($messages as $value) {
        $message .= $value . ' <br>';
    }
    $script = '<script type="text / javascript">
	setTimeout(function () {
		jq(" . errors").hide(2000, function() {
			jq(this).remove();
		});
}, 10000);
</script> ';

    return '<div class="errors alert alert-' . $type . '"><h5><strong> ' . \Str::hes($head) . '</strong></h5>' . \Str::hes($message) . '</div>' . $script;
});

/**
 * RESPONSIVE MULTI OPTIONS
 */
\HTML::macro('responsiveOpt', function (\PreguntaCabecera $question, $max = 7, $isSubQuestion = false, $text = 'Calificaci&oacute;n') {
    $responsive = array(
        'class'                    => 'form-control',
        'data-placeholder'         => '...',
        'data-fv-notempty',
        'data-fv-notempty-message' => \Lang::get('validation.required', ['attribute' => '']),
    );

    //Debugbar::addMessage('RESPONSIVEOPTION | ID PREGUNTA: ' . $question->id_pregunta_cabecera . ' NUMERO PREGUNTA: ' . $question->numero_pregunta);

    return '<div class="form-group table-responsive hidden-md hidden-lg">
	<table class="table table-hover table-condensed">
		<thead class="text-center">
			<tr>
				<td></td>
				<td></td>
			</tr>
		</thead>
		<tbody class="text-center">
			<tr>
				<td class="text-left vertical-align">
					<label class="control-label">' . $text . '</label>
				</td>
				<td class="">' . \Form::selectRange2('question_' . $question->numero_pregunta . '_' . $question->id_pregunta_cabecera . '[value]', '1', $max, null, $responsive) . '</td>
			</tr>
		</tbody>
	</table>
</div>';
});

/**
 * MULTI OPTIONS
 */
\HTML::macro('multiOptions', function (\PreguntaCabecera $question, $isSubQuestion = false) {
    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('MULTIOPTIONS | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    return $out;
});

/**
 * SINGLE OPTIONS
 */
\HTML::macro('singleOptions', function (\PreguntaCabecera $question, $max = 7, $isSubQuestion = false, $text = 'Calificaci&oacute;n') {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('SINGLEOPTIONS | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    if (isset($max) && $max > 0) {
        $out .= \HTML::responsiveOpt($question, $max, $isSubQuestion);
        $out .= '<div class="form-group table-responsive hidden-xs hidden-sm">
		<table class="table table-hover table-condensed">
			<thead class="text-center">
				<tr>
					<td></td>';

        for ($i = 1; $i <= $max; $i++) {
            $out .= '<td class="text-center">' . $i . '</td>';
        }

        $out .= '</tr>
				</thead>
				<tbody class="text-center">
					<tr>
						<td class="text-left vertical-align">
							<label class="control-label">' . $text . '</label>
						</td>';

        for ($i = 1; $i <= $max; $i++) {
            if ($i == 1) {
                $out .= '<td>
								<input type="radio" class=""  name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[value]" value="' . $i . '"  data-fv-notempty data-fv-notempty-message="' . \Lang::get('validation . required',
                        ['attribute' => '']) . '" data-fv-choice="true">
							</td>';
            } else {
                $out .= '<td>
							<input type="radio" class=""  name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[value]" value="' . $i . '">
						</td>';
            }
        }

        $out .= '</tr>
			</tbody>
		</table>';
        $out .= '</div>';
        $out .= '<div class="messageContainer"></div>';
    } else {
        $out .= \HTML::alert('warning', array('Cantidad de opciones no declarada en la funci�n.'), 'ATENCI�N!...');
    }

    return $out;
});

/**
 * TEXT OPTIONS
 */
\HTML::macro('textOptions', function (\PreguntaCabecera $question, $multi, $isSubQuestion = false) {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $textarea          = array(
            'placeholder'                  => '...',
            'class'                        => 'form-control',
            'rows'                         => 3,
            'length'                       => 250,
            'data-fv-stringlength'         => 'true',
            'data-fv-stringlength-min'     => 0,
            'data-fv-stringlength-max'     => 250,
            'data-fv-stringlength-message' => \Lang::get('validation.max.string', ['attribute' => '', 'max' => 250]),
        );
        $textbox           = array(
            'placeholder' => '...',
            'class'       => 'form-control',
        );
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $textarea          = array(
            'placeholder'                  => '...',
            'class'                        => 'form-control',
            'rows'                         => 3,
            'length'                       => 300,
            'data-fv-notempty'             => true,
            'data-fv-notempty-message'     => Lang::get('validation.required', ['attribute' => '']),
            'data-fv-stringlength'         => true,
            'data-fv-stringlength-min'     => 0,
            'data-fv-stringlength-max'     => 250,
            'data-fv-stringlength-message' => Lang::get('validation.max.string', ['attribute' => '', 'max' => 250]),
        );
        $textbox           = array(
            'placeholder' => '...',
            'class'       => 'form-control',
        );
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('TEXTOPTION | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    $out .= '<div class="form-group">';

    if ($multi) {
        $out .= \Form::textarea('question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]', null, $textarea);
        $out .= '<small class="count"></small>';
    } else {
        $out .= \Form::text('question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]', null, $textbox);
    }

    //$out .= '<div class="messageContainer"></div>';
    $out .= '</div>';

    return $out;
});

/**
 * RANGE OPTIONS
 */
\HTML::macro('rangeOptions', function (\PreguntaCabecera $question, $isSubQuestion = false) {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    $out .= '<div class="form-group">';
    // ...
    //$out .= '<div class="messageContainer"></div>';
    $out .= '</div>';

    return $out;
});

/**
 * BOOLEAN OPTIONS
 */
\HTML::macro('booleanOptions', function (\PreguntaCabecera $question, $isSubQuestion = false) {

    $out = '';

    if ($isSubQuestion) {
        $pregunta_padre    = \PreguntaCabecera::select(array('id_pregunta_cabecera', 'numero_pregunta'))->whereIdPreguntaCabecera($question->id_pregunta_padre)->first(array(
            'id_pregunta_cabecera',
            'numero_pregunta',
        ));
        $numero_pregunta   = $pregunta_padre->numero_pregunta;
        $id_pregunta_padre = $pregunta_padre->id_pregunta_cabecera;
        $out .= \HTML::getSubQuestion($question->descripcion_1);
    } else {
        $numero_pregunta   = $question->numero_pregunta;
        $id_pregunta_padre = $question->id_pregunta_cabecera;
        $out .= \HTML::getMainQuestion($question->descripcion_1, $numero_pregunta);
    }

    //Debugbar::addMessage('BOOLEANOPTION | ID PREGUNTA: ' . $id_pregunta_padre . ' NUMERO PREGUNTA: ' . $numero_pregunta);

    $out .= '<div class="form-group table-responsive">
	<table class="table table-hover table-condensed">
		<thead class="text-center">
			<tr>
				<td style="width: 33 %;"></td>
				<td style="width: 33 %;">' . \Str::hes(\Lang::get('messages.yes')) . '</td>
				<td style="width: 33 %;">' . \Str::hes(\Lang::get('messages.no')) . '</td>
			</tr>
		</thead>
		<tbody class=" text-center">
			<tr class="">
				<td style="width: 33 %;" class="text-left vertical-align"><label class="control-label">' . \Str::hes('Opci�n') . '</label></td>
				<td style="width: 33 %;"><input type="radio" name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]" value="SI" data-fv-notempty data-fv-notempty-message="' . \Lang::get('validation . required',
            ['attribute' => '']) . '"></td>
				<td style="width: 33 %;"><input type="radio" name="question_' . $numero_pregunta . '_' . $id_pregunta_padre . '[text]" value="NO"></td>
			</tr>
		</tbody>
	</table>';
    $out .= '</div>';
    $out .= '<div class="messageContainer"></div>';

    return $out;
});

/**
 * CREATE ALL QUESTIONS
 */
\HTML::macro('createQuestions', function (\PreguntaCabecera $question, $isSubQuestion = false) {
    $out = '';

    if (!$isSubQuestion) {
        $out = '<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    }

    //dd($question->id_tipo_respuesta);
    switch ($question->id_tipo_respuesta) {
        case 1:
            //Opcion �nica
            $out .= \HTML::singleOptions($question, 7, $isSubQuestion);
            break;
        case 2:
            //Multiopcion
            $out .= \HTML::multiOptions($question, $isSubQuestion);
            break;
        case 3:
            //Por rango de valor
            $out .= \HTML::rangeOptions($question, $isSubQuestion);
            break;
        case 4:
            //Respuesta texto (Linea simple)
            $out .= \HTML::textOptions($question, false, $isSubQuestion);
            break;
        case 5:
            //Respuesta texto (Multilinea)
            $out .= \HTML::textOptions($question, true, $isSubQuestion);
            break;
        case 6:
            //Booleana
            $out .= \HTML::booleanOptions($question, $isSubQuestion);
            break;
    }

    //$subQuestion = PreguntaCabecera::select(array('id_pregunta_cabecera', 'descripcion_1', 'numero_pregunta', 'id_pregunta_padre', 'id_tipo_respuesta'))->whereIdPreguntaPadre($question->id_pregunta_cabecera)->whereNumeroPregunta(null)->first(array('id_pregunta_cabecera', 'descripcion_1', 'numero_pregunta', 'id_pregunta_padre', 'id_tipo_respuesta'));
    $subQuestion = \PreguntaCabecera::whereIdPreguntaPadre($question->id_pregunta_cabecera)->whereNumeroPregunta(null)->first();

    if (!is_null($subQuestion)) {
        $out .= \HTML::createQuestions($subQuestion, true);
    }

    if (!$isSubQuestion) {
        $out .= '</article>';
    }

    return $out;
});

/**
 * GENERATE SURVEY
 */
\HTML::macro('generateSurvey', function ($survey = null) {

    if (!isset($survey) && !$survey->exists) {
        return \HTML::alert('danger', array('No existe encuesta asociada.'), 'Atenci�n!...');
    }

    $questions = $survey->preguntas;

    if (count($questions) <= 0) {
        return \HTML::alert('warning', array('No existen preguntas para esta encuesta.'), 'Atenci�n!...');
    }

    //$options_count = 7;
    $out = '';
    foreach ($questions as $key => $question) {
        if ($question->id_pregunta_padre === null) {
            $out .= \HTML::createQuestions($question);
        }
    }

    return $out;
});

/**
 * ---------------------------
 *  FORM ADD OR MODIFY SURVEY
 * ---------------------------
 */
//\Form::macro('loadSurvey', function (\Encuesta $survey, $idplan = 1) {
\Form::macro('loadSurvey', function (\Encuesta $survey, $isMy = false) {

    $out      = '';
    $readonly = false;

    //    $idpplan = \Plan::select('id_plan')->where('descripcion_plan', 'LIKE', '%free%')->first('id_plan')->id_plan;
    //    if ((int)$idplan == (int)$idpplan) {
    if (!$isMy) {
        $readonly = true;
    }

    if (!isset($survey) && !$survey->exists) {
        return \HTML::alert('danger', array('No existe encuesta asociada.'), 'Atenci&oacute;n!...');
    }

    $questions = $survey->preguntas;

    if (count($questions) <= 0) {
        return \HTML::alert('warning', array('No existen preguntas para esta encuesta.'), 'Atenci&oacute;n!...');
    }

    $count = 1;
    foreach ($questions as $key => $question) {
        if ($question->id_pregunta_padre === null) {
            $name = $count++ . '.- ' . \Categoria::find($question->id_categoria)->descripcion_categoria;
            $out .= \Form::generateInput($name, $question, $readonly);
        }
    }

    return $out;
});

\Form::macro('generateInput', function ($title, \PreguntaCabecera $question, $readonly = false) {
    $ro = '';

    if ($readonly) {
        $ro = 'readonly';
    }

    $out = '<div class="form-group">';
    $out .= '<h3>' . \Form::label('question' . $question->id_pregunta_cabecera, $title) . '</h3>';
    $out .= \Form::textarea('question' . $question->id_pregunta_cabecera, trim($question->descripcion_1), ['class' => 'form-control ckeditor', $ro]);
    $out .= '</div>';

    return $out;
});
\HTML::macro('getMainQuestion', function ($text, $number = 0) {
    if (isset($number) && $number != 0) {
        $text = '<h4><strong>' . \Str::hes($number . '.- ' . $text) . '</strong></h4>';
    } else {
        $text = '<h4><strong>' . \Str::hes($text) . '</strong></h4>';
    }

    return $text;
});
\HTML::macro('getSubQuestion', function ($text, $number = 0) {
    if (isset($number) && $number != 0) {
        $text = '<h5><strong>' . \Str::hes($number . '.- ' . $text) . '</strong></h5>';
    } else {
        $text = '<h5><strong>' . \Str::hes($text) . '</strong></h5>';
    }

    return $text;
});


/**
 *
 */
\Form::macro('questionForm', function ($name, $questionNumber = 0, $isSubQuestion = false, $category = null) {

    $out  = '';
    $kind = 1;
    $sub  = '';
    if ($isSubQuestion) {
        $sub = '[sub]';
        if ($questionNumber == 4) {
            $kind = 6;
        } else {
            $kind = 5;
        }
    }


    if ($category == null) {
        return \HTML::alert('warning', ['Categoría no encontrada.'], '<h3>Atención!</h3>');
    }

    $n = $name . "[" . $questionNumber . "]" . $sub . "[descripcion_1]";

    $text1 = '<div class="form-group">' .
                    \Form::label($n, "Texto 1:", array("class" => "col-md-2 control-label")) .
                    '<div class="col-sm-10">' .
                        \Form::textarea($n, \Input::old($n), array("class" => "form-control ckeditor", "placeholder" => "Texto 1", "readonly")) .
        			'</div></div>';

//    $text2 = '<div class="form-group">
//								' . \Form::label($name . "[" . $questionNumber . "]" . $sub . "[descripcion_2]", "Texto 2:", array("class" => "col-md-2 control-label")) . '
//								<div class="col-sm-10">
//									' . \Form::text($name . "[" . $questionNumber . "]" . $sub . "[descripcion_2]", \Input::old($name . "[" . $questionNumber . "]" . $sub . "[descripcion_2]"),
//            array("class" => "form-control", "placeholder" => "Texto 2")) . '
//								</div>
//							</div>';
//
//    $text3 = '<div class="form-group">
//								' . \Form::label($name . "[" . $questionNumber . "]" . $sub . "[descripcion_3]", "Texto 3:", array("class" => "col-md-2 control-label")) . '
//								<div class="col-sm-10">
//									' . \Form::text($name . "[" . $questionNumber . "]" . $sub . "[descripcion_3]", \Input::old($name . "[" . $questionNumber . "]" . $sub . "[descripcion_3]"),
//            array("class" => "form-control", "placeholder" => "Texto 3")) . '
//								</div>
//							</div>';

    $n = $name . "[" . $questionNumber . "]" . $sub . "[numero_pregunta]";
    $number = '<div class="form-group" >' .
                    \Form::label($n, "N° Pregunta:", array("class" => "col-md-2 control-label")) .
                    '<div class="col-sm-10" >' .
                        \Form::text($n, $questionNumber + 1, array("class" => "form-control", "placeholder" => "Numero Pregunta", "readonly")) .
                    '</div></div >';

    $categoryID     = \Form::hidden($name . "[" . $questionNumber . "]" . $sub . "[id_categoria]", $category, array("class" => "form-control"));
    $kindOfQuestion = \Form::hidden($name . "[" . $questionNumber . "]" . $sub . "[id_tipo_respuesta]", $kind, array("class" => "form-control"));

    if (!$isSubQuestion) {
        $out .= $number;
    }

    $out .= $text1;
    //    $out .= $text2;
    //    $out .= $text3;
    $out .= $categoryID;
    $out .= $kindOfQuestion;

    return $out;
});