<?php

namespace Drupal\qr_gen\Service;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Drupal\Core\Entity\EntityTypeManager;

class ContentService
{

  protected $entityTypeManager;

  protected $data;

  protected $id;

  const QR_PATH = 'public://qr/';

  public function __construct(EntityTypeManager $entityTypeManager){
    $this->entityTypeManager = $entityTypeManager;
  }

  public function setData($data){
    $this->data = $data;
    return $this;
  }

  public function setID($id){
    $this->id = $id;
    return $this; 
  }

  public function encode(){
    $data = $this->data ? $this->data : 'drupal';
    $id   = $this->id;
    $result = Builder::create()
    ->writer(new PngWriter())
    ->writerOptions([])
    ->data($data)
    ->encoding(new Encoding('UTF-8'))
    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
    ->size(300)
    ->margin(10)
    ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->labelText('Scan here on youre mobile')
    ->labelFont(new NotoSans(10))
    ->labelAlignment(new LabelAlignmentCenter())
    ->build()
    ->saveToFile(self::QR_PATH.$id.'.png');
    return $result;
  }
}