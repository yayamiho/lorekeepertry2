<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\Carousel\Carousel;
use App\Services\CarouselService;
use Auth;
use Illuminate\Http\Request;
use Log;

class CarouselController extends Controller {
    /**
     * Shows the carousel index.
     *
     * @param string $folder
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex($folder = null) {
        $carousels = Carousel::orderBy('sort', 'DESC')->get();

        return view('admin.carousel.index', [
            'carousels' => $carousels,
        ]);
    }

    /**
     * Uploads a carousel image file.
     *
     * @param App\Services\FileManager $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUploadCarousel(Request $request, CarouselService $service) {
        $request->validate(Carousel::$createRules);
        $data = $request->only('image', 'alt_text', 'link');

        if ($service->createCarousel($data, Auth::user())) {
            flash('New carousel section uploaded successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Creates or edits a carousel.
     *
     * @param App\Services\ItemService $service
     * @param int                      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteCarousel(Request $request, CarouselService $service, $id) {
        if ($id && $service->deleteCarousel(Carousel::find($id), Auth::user())) {
            flash('Carousel deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->to('admin/data/carousel');
    }

    public function getDeleteCarousel($id) {
        $carousel = Carousel::find($id);

        return view('admin.carousel._delete_carousel', [
            'carousel' => $carousel,
        ]);
    }

    public function getEditCarousel($id) {
        $carousel = Carousel::find($id);

        return view('admin.carousel._edit_carousel', [
            'carousel' => $carousel,
        ]);
    }

    /**
     * Creates or edits a carousel.
     *
     * @param App\Services\CarouselService $service
     * @param int|null                 $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditCarousel(Request $request, CarouselService $service, $id = null) {
        $request->validate(Carousel::$updateRules);
        $data = $request->only('image', 'alt_text', 'link', 'is_visible');
        if ($id && $service->updateCarousel(Carousel::find($id), $data, Auth::user())) {
            flash('Carousel updated successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Sorts carousels.
     *
     * @param App\Services\CarouselService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortCarousel(Request $request, CarouselService $service) {
        if ($service->sortCarousel($request->get('sort'))) {
            flash('Carousel order updated successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }
}
