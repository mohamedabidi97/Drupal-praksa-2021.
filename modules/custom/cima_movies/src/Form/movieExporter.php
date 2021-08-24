<?php

namespace Drupal\cima_movies\Form;

use \Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class movieExporter extends FormBase
{
  protected $fetchData;

  public function __construct($fetchData)
  {
    $this->fetchData = $fetchData;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('cima_movies.custom_services')
    );
  }

  public function getFormId()
  {
    return 'cima_movies';
  }

  public function buildRow(Node $data)
  {
    $data = [
      'name' => $data->getTitle(),
      'description' => $data->field_description->value,
      'poster' => file_create_url($data->field_image_movie->entity->getFileUri()),
      'days' => $this->fetchData->getNamebyId($data->get('field_days')->target_id),
      'genre' => $this->fetchData->getNamebyId($data->get('field_genre')->target_id)
    ];

    return $data;
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['extension'] = array(
      '#title' => t('Extensions'),
      '#type' => 'select',
      '#description' => 'Select which file extension you want.',
      '#options' => array('CSV', 'XML'),
    );
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $key = $form_state->getValue('extension');
    $val = $form['extension']['#options'][$key];
    try {
      $contentData = $this->fetchData->getIncludedMovies();
      foreach ($contentData as $data) {
        $moviesList[] = array(
          'name' => $data->getTitle(),
          'description' => $data->field_description->value,
          'poster' => file_create_url($data->field_image_movie->entity->getFileUri()),
          'days' => $this->fetchData->getNamebyId($data->get('field_days')->target_id),
          'genre' => $this->fetchData->getNamebyId($data->get('field_genre')->target_id)
        );
      }
      if ($val == 'CSV') {
        $output = fopen("php://output", "w");
        $header = array_keys($moviesList[0]);
        fputcsv($output, $header);
        foreach ($moviesList as $movie) {
          fputcsv($output, $movie);
        }
        rewind($output);
        $csvFile = stream_get_contents($output);
        fclose($output);
        exit($csvFile);
      } else {
        $xmlEncoder = new XmlEncoder();
        header("Content-type: text/xml");
        header("Content-Disposition: attachment; filename=movies.xml");
        $xmlFile = $xmlEncoder->encode($moviesList, 'xml');
        exit($xmlFile);
      }
    } catch
    (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}
