<?php

namespace App\Services\Blog;

use Carbon\Carbon;
use App\Models\Blog\Blog;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Blog\BlogResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogService extends BaseService
{

    /**
     * @param Request $request
     * @return array
     */
    public function sanitizeStoreRequestData(Request $request): array
    {
        return [
            Blog::COLUMN_TITLE => $request->post('title'),
            Blog::COLUMN_SLUG => $request->post('slug'),
            'image' => $request->file('image'),
            Blog::COLUMN_BODY => $request->post('body'),
        ];
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        DB::transaction(function () use ($data) {
            /**
             * File Upload
             */
            $directoryPath = 'public/blog/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now(
                )->day;
            $filePath = Storage::put($directoryPath, $data['image']);

            /**
             * DB create
             */
            $item = new Blog();
            $item->setTitle($data[Blog::COLUMN_TITLE])
                ->setSlug($data[Blog::COLUMN_SLUG])
                ->setImagePath(str_replace('public/', '', $filePath))
                ->setBody($data[Blog::COLUMN_BODY])
                ->save();
        });
    }

    /**
     * @param Blog $blog
     * @param array $data
     * @return void
     */
    public function update(Blog $blog, array $data): void
    {
        DB::transaction(function () use ($blog, $data) {

            if (!empty($data[Blog::COLUMN_TITLE])) {
                $blog->setTitle($data[Blog::COLUMN_TITLE]);
            }

            if (!empty($data[Blog::COLUMN_SLUG])) {
                $blog->setSlug($data[Blog::COLUMN_SLUG]);
            }

            if (!empty($data['image'])) {

                /**
                 * File Upload
                 */
                $directoryPath = 'public/blog/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . Carbon::now(
                    )->day;
                $filePath = Storage::put($directoryPath, $data['image']);

                $blog->setImagePath(str_replace('public/', '', $filePath));
            }

            if (!empty($data[Blog::COLUMN_BODY])) {
                $blog->setBody($data[Blog::COLUMN_BODY]);
            }

            $blog->save();
        });
    }

    /**
     * @param int $page
     * @return AnonymousResourceCollection
     */
    public function getAll(int $page): AnonymousResourceCollection
    {
        $items = Blog::forPage($page, $this->perPage)->get();

        return BlogResource::collection($items);
    }

    /**
     * @return int
     */
    public function countTotal(): int
    {
        return Blog::count();
    }

}
