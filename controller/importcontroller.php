<?php
/**
 * Created by PhpStorm.
 * User: tcit
 * Date: 27/09/16
 * Time: 12:23
 */

namespace OCA\calendar\controller;


use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\NotFoundException;
use OCP\IRequest;

class ImportController extends Controller {

	private $folder;

	/**
	 * ImportController constructor.
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param Folder $folder
	 */
	public function __construct($appName, IRequest $request, Folder $folder) {
		parent::__construct($appName, $request);
		$this->folder = $folder;
	}

	/**
	 * @param integer $fileid
	 * @return JSONResponse
	 * @throws \Exception
	 */
	public function import($fileid) {
		try {
			$file = $this->folder->getById($fileid);
			if($file[0] instanceof File) {
				return new JSONResponse([
						'body' => $file[0]->getContent(),
						'name' => $file[0]->getName(),
				]);
			} else {
				throw new \Exception('Can not read from folder');
			}
		} catch(NotFoundException $e) {
			throw new \Exception('File does not exist');
		}
	}
}