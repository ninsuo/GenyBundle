<?php
require_once("../../GenyBundle-demo/vendor/autoload.php");

$converter = new Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter();

$trans = [];

$glob = glob("../vendor/symfony/validator/Constraints/*.php");
foreach ($glob as $file) {
    if (strpos($file, 'Validator') !== false) {
        continue;
    }

    $constraint = str_replace(".php", '', basename($file));
    echo $constraint, PHP_EOL;

    $cs = trim($converter->normalize($constraint), '_');

    $options = get_class_vars("Symfony\\Component\\Validator\\Constraints\\{$constraint}");

    $json           = array();
    $json['name']   = $cs;
    $json['type']   = 'container';
    $json['fields'] = array();

    foreach ($options as $name => $default) {
        $snakeName = $converter->normalize($name);

        $transkeu = 'geny.validator.'.$cs.'.'.$snakeName;
        $trans[] = $transkeu;

        $json['fields'][$snakeName] = [
            'type'       => 'text',
            'data'       => $default,
            'options'    => [
                'label' => $transkey,
            ],
            'validators' => [],
        ];
    }

    echo json_encode($json, JSON_PRETTY_PRINT), PHP_EOL;
}



$index = 42;
foreach ($trans as $key) {

echo '
      <trans-unit id="'.$index.'">
        <source>'. $key .'</source>
        <target><![CDATA[]]></target>
      </trans-unit>';
    $index++;
}
