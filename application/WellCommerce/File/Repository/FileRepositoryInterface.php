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

namespace WellCommerce\File\Repository;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface FileRepositoryInterface
 *
 * @package WellCommerce\File\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FileRepositoryInterface
{
    const PRE_DELETE_EVENT  = 'file.repository.pre_delete';
    const POST_DELETE_EVENT = 'file.repository.post_delete';
    const PRE_SAVE_EVENT    = 'file.repository.pre_save';
    const POST_SAVE_EVENT   = 'file.repository.post_save';

    /**
     * Returns all files as a collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    /**
     * Returns a file model
     *
     * @param $id
     *
     * @return \WellCommerce\File\Model\File
     */
    public function find($id);

    /**
     * Saves information about uploaded file
     *
     * @param UploadedFile $file
     *
     * @return mixed
     */
    public function save(UploadedFile $file);

    /**
     * Deletes a file
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);
}