<?php

namespace nullref\cms\generators\block;

use Yii;
use yii\gii\CodeFile;
use yii\gii\Generator as BaseGenerator;


class Generator extends BaseGenerator
{
    const FORM_NAME = '_form';
    const BLOCK_NAME = 'Block';
    const WIDGET_NAME = 'Widget';

    public $blockName = 'NewBlock';
    public $blockModel = 'nullref\cms\components\Block';
    public $widgetModel = 'nullref\cms\components\Widget';
    public $destinationPath = 'app\components\blocks\newBlock';


    public function generate()
    {
        //Init _form.php
        $files[] = new CodeFile(
            Yii::getAlias('@' . str_replace('\\', '/', $this->destinationPath)) . '/' . $this::FORM_NAME . '.php',
            $this->render('_form.php', [])
        );
        //Init block.php
        $files[] = new CodeFile(
            Yii::getAlias('@' . str_replace('\\', '/', $this->destinationPath)) . '/' . $this::BLOCK_NAME . '.php',
            $this->render('block.php', [
                'blockName' => $this->blockName,
                'destination' => $this->destinationPath,
                'blockModel' => $this->blockModel,
            ])
        );
        //Init widget.php
        $files[] = new CodeFile(
            Yii::getAlias('@' . str_replace('\\', '/', $this->destinationPath)) . '/' . $this::WIDGET_NAME . '.php',
            $this->render('widget.php', [
                'blockName' => $this->blockName,
                'destination' => $this->destinationPath,
                'widgetModel' => $this->widgetModel,
            ])
        );

        return $files;
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        $output = <<<EOD
<p>The block has been generated successfully.</p>
<p>To use the block, you need to add this to your application configuration in modules.php:</p>
EOD;
        $code = <<<EOD
    ......
    'cms' => [
       'class' => 'nullref\cms\Module',
       'blockManagerClass' =>[
          'class'=> 'nullref\cms\components\BlockManager',
          'blocks'=>[
             '$this->blockName'=> '$this->destinationPath',
          ]
       ],
   ],
    ......
EOD;
        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['blockName', 'blockModel', 'widgetModel'], 'required'],
            //['blockName', 'unique', 'message' => Yii::t('cms','Block with this name already exist')],
            ['destinationPath', 'safe'],
            ['destinationPath', 'default', 'value' => '@nullref/cms/blocks/newBlock'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'blockName' => 'Block Name',
            'blockModel' => 'Block Model Class',
            'widgetModel' => 'Widget Model Class',
            'destinationPath' => 'Destination Path',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'blockName' => 'You should set name for your block',
            'blockModel' => 'You should provide a fully qualified class name, e.g., <code>nullref\cms\components\Block</code>.',
            'widgetModel' => 'You should provide a fully qualified class name, e.g., <code>nullref\cms\components\Widget</code>.',
            'destinationPath' => 'Specify the directory for storing the files for your new block. You may use path alias here, e.g.,
                <code>app\components\blocks\newBlock</code>'
        ]);
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Block Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a block for cms';
    }

}