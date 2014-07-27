<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Producer\Repository;

use WellCommerce\Core\Repository\AbstractRepository;
use WellCommerce\Producer\Model\Producer;
use WellCommerce\Producer\Model\ProducerTranslation;

/**
 * Class ProducerAbstractRepository
 *
 * @package WellCommerce\Producer\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerRepository extends AbstractRepository implements ProducerRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Producer::with('translation', 'shop', 'deliverer')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Producer::with('translation', 'shop', 'deliverer')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $producer = $this->find($id);
        $producer->delete();
        $this->dispatchEvent(ProducerRepositoryInterface::POST_DELETE_EVENT, $producer);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            $producer = Producer::firstOrCreate([
                'id' => $id
            ]);

            $data = $this->dispatchEvent(ProducerRepositoryInterface::PRE_SAVE_EVENT, $producer, $data);

            $producer->update($data);

            foreach ($this->getLanguageIds() as $language) {

                $translation = ProducerTranslation::firstOrCreate([
                    'producer_id' => $producer->id,
                    'language_id' => $language
                ]);

                $translationData = $translation->getTranslation($data, $language);
                $translation->update($translationData);
            }

            $producer->sync($producer->deliverer(), $data['deliverers']);
            $producer->sync($producer->shop(), $data['shops']);

            $this->dispatchEvent(ProducerRepositoryInterface::POST_SAVE_EVENT, $producer, $data);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProducerToSelect()
    {
        return $this->all()->toSelect('id', 'translation.name', $this->getCurrentLanguage());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProducerToFilter()
    {
        return $this->all()->toDataGridFilter('id', 'translation.name', $this->getCurrentLanguage());
    }
}