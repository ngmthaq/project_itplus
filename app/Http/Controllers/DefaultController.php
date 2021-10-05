<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DefaultController extends Controller
{
    public function index()
    {
        // Site
        $site = 'homepage';
        // Categories
        $categories = Category::all();
        // All posts
        $posts = Post::with(['category', 'type', 'comments'])->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        // Slider data
        $firstSliders = $posts->where('type_id', '=', '1')->take(5);
        // Video posts
        $videoPosts = $posts->where('type_id', '=', '2')->take(2);
        // Chính trị
        $firstPolitic = $posts->where('category_id', '=', '1')->take(1)->first();
        $politics = $posts->where('category_id', '=', '1')->skip(1)->take(4);
        $politicTopComments = Post::postWithComments($posts->where('category_id', '=', '1'));
        // Kinh doanh
        $firstBusiness = $posts->where('category_id', '=', '2')->take(1)->first();
        $business = $posts->where('category_id', '=', '2')->skip(1)->take(4);
        $businessTopComments = Post::postWithComments($posts->where('category_id', '=', '2'));
        // KH & CN => Science & Technology => SnT
        $firstSnT = $posts->where('category_id', '=', '3')->take(1)->first();
        $SnTs = $posts->where('category_id', '=', '3')->skip(1)->take(4);
        $SnTTopComments = Post::postWithComments($posts->where('category_id', '=', '3'));
        // SK & CĐ => Health & Community => HnC
        $firstHnC = $posts->where('category_id', '=', '4')->take(1)->first();
        $HnCs = $posts->where('category_id', '=', '4')->skip(1)->take(4);
        $HnCTopComments = Post::postWithComments($posts->where('category_id', '=', '4'));
        // Du lịch
        $firstTravel = $posts->where('category_id', '=', '5')->take(1)->first();
        $travels = $posts->where('category_id', '=', '5')->skip(1)->take(4);
        $travelTopComments = Post::postWithComments($posts->where('category_id', '=', '5'));
        // Thể thao
        $firstSport = $posts->where('category_id', '=', '6')->take(1)->first();
        $sports = $posts->where('category_id', '=', '6')->skip(1)->take(4);
        $sportTopComments = Post::postWithComments($posts->where('category_id', '=', '6'));
        return view('web.main.homepage', compact(
            'site', 'categories', 'firstSliders', 'videoPosts',
            'firstPolitic', 'politics', 'politicTopComments',
            'firstBusiness', 'business', 'businessTopComments',
            'firstSnT', 'SnTs',  'SnTTopComments',
            'firstHnC', 'HnCs',  'HnCTopComments',
            'firstTravel', 'travels', 'travelTopComments',
            'firstSport', 'sports', 'sportTopComments',
        ));
    }

    public function breakingNews()
    {
        $categories = Category::all();
        $site = 'breaking-news';
        $posts = Post::with(['category', 'comments', 'type'])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        return view('web.main.breaking-new', compact(
            'site', 'categories', 'posts'
        ));
    }

    public function loadmoreBreakingNews($post)
    {
        $posts = Post::with(['category', 'comments', 'type'])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->skip($post)
            ->take(6)
            ->get();
        return view('web.parts.posts._breaking-news', compact('posts'));
    }

    public function about()
    {
        return view('web.main.about-us', [
            'site' => 'about',
            'categories' => Category::all()
        ]);
    }

    public function contact()
    {
        return view('web.main.contact', [
            'site' => 'contact',
            'categories' => Category::all()
        ]);
    }

    public function addFeedback(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required',
        ]);
        $feedback = DB::table('feedbacks')->insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if ($feedback) {
            return redirect(route('contact'))->with('success', 'Gửi phản hồi thành công');
        }
        return redirect(route('contact'))->with('error', 'Gửi phản hồi thất bại, xin vui lòng thử lại');
    }

    public function policy()
    {
        return view('web.main.policy', [
            'site' => 'policy',
            'categories' => Category::all()
        ]);
    }

    public function terms()
    {
        return view('web.main.terms', [
            'site' => 'terms',
            'categories' => Category::all()
        ]);
    }
}
