<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

use App\Models\Customer;
use App\Models\Admin;
use App\Models\OrderDetail;
use App\Models\Comment;
use App\Models\SlideShow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Mail;
session_start();
class CommentController extends Controller
{
    public function Index(){
        $this->AuthLogin();
        $comment_customer=Comment::where('binhluan_id_phan_hoi','=',0)->orderby('id','DESC')->paginate(5);
        $comment_admin=Comment::where('binhluan_id_phan_hoi','>',0)->paginate(5);
        return view('admin.pages.comment.show_comment')->with(compact('comment_customer', 'comment_admin'));
    }

    public function PostCommentCustomer(Request $request){
        $data=$request->all();
        $customer=Session::get('customer_id');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $comment_date = Carbon::now('Asia/Ho_Chi_Minh');
        // var_dump($data['review_name']);
        if($data['review_name']==NULL || $data['review_comment']==NULL || $data['starRateV']==NULL){
            return redirect()->back()->with('error','Fail,Please enter all fields and select a rating star');
        }else{
            if($customer){
                $comment=new Comment();
                $comment->binhluan_ten_nguoi_danh_gia=$data['review_name'];
                $comment->binhluan_noi_dung=$data['review_comment'];
                $comment->binhluan_diem_danh_gia=$data['starRateV'];
                $comment->binhluan_ngay_danh_gia=$comment_date;
                $comment->binhluan_trang_thai=0;
                $comment->binhluan_id_phan_hoi=0;
                $comment->admin_id=0;
                $comment->khachhang_id=$customer;
                $comment->sanpham_id=$data['product_id'];
                $comment->save();
            }else{
                $comment=new Comment();
                $comment->binhluan_ten_nguoi_danh_gia=$data['review_name'];
                $comment->binhluan_noi_dung=$data['review_comment'];
                $comment->binhluan_diem_danh_gia=$data['starRateV'];
                $comment->binhluan_ngay_danh_gia=$comment_date;
                $comment->binhluan_trang_thai=0;
                $comment->binhluan_id_phan_hoi=0;
                $comment->admin_id=0;
                $comment->sanpham_id=$data['product_id'];
                $comment->save();
            }
            return redirect()->back()->with('message','Successfully added review, pending approval');
        }
    }

    public function LoadComment(Request $request){
        $product_id=$request->comment_product_id;
        $comment_customer=Comment::where('sanpham_id',$product_id)->where('binhluan_id_phan_hoi','=',0)->get();
        $comment_admin=Comment::with('Product')->where('binhluan_id_phan_hoi','>',0)->get();
        $output = '';
        foreach($comment_customer as $key => $comment){
            $output .= '
                <div class="product_info_inner ">
                    <div class="product_ratting mb-10 col-md-6">
                        <ul>';
                        for($count=1;$count<=5;$count++){
                            if($count <= $comment->binhluan_diem_danh_gia){
                                $output .= '
                                    <i class="fa fa-star ratting_review"></i>
                                ';
                            }else{
                                $output .= '
                                    <i class="fa fa-star ratting_no_review"></i>
                                ';
                            }
                        }
                            $output .= '
                        </ul>
                        <strong>'.$comment->binhluan_ten_nguoi_danh_gia.'</strong>
                        <p>'.$comment->binhluan_ngay_danh_gia.'</p>
                        <p>'.$comment->binhluan_noi_dung.'</p>
                    </div>
                    &emsp;&emsp;';
                    foreach($comment_admin as $k =>$ad_comment){
                        if($ad_comment->binhluan_id_phan_hoi==$comment->id){
                            $output .= '
                            <div class="col-md-6">
                            <div class="product_demo">
                                <strong>Admin</strong>
                                <p>'.$ad_comment->binhluan_noi_dung.'</p>
                            </div>
                        </div>
                            ';
                        }
                    }
                    $output .= '
                </div>
            ';
        }
        echo $output;
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function ApprovalComment(Request $request) {
        $this->AuthLogin();
		$data = $request->all();
		$comment = Comment::find($data['comment_id']);
		$comment->binhluan_trang_thai = $data['comment_status'];
		$comment->save();
	}

    public function ShowCommentDetail($comment_id){
        $this->AuthLogin();
        $comment=Comment::find($comment_id);
        $comment_reply=Comment::where('binhluan_id_phan_hoi',$comment_id)->orderby('id','ASC')->get();
        return view('admin.pages.comment.show_comment_detail')->with(compact('comment_reply','comment'));
    }

    public function AdminReplyToComment(Request $request){
        $this->AuthLogin();
		$data = $request->all();
        $user_id=Session::get('admin_id');
        $admin_id=Admin::where('user_id',$user_id)->first();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $comment_date = Carbon::now('Asia/Ho_Chi_Minh');
        if($data['reply_admin_comment']==NULL){
            return redirect()->back()->with('error','Fail, Please enter a comment');
        }else{
            if(isset($data['reply_customer_id'])){
                $comment=new Comment();
                $comment->binhluan_ten_nguoi_danh_gia='Admin RGUWB';
                $comment->binhluan_noi_dung=$data['reply_admin_comment'];
                $comment->binhluan_ngay_danh_gia=$comment_date;
                $comment->binhluan_trang_thai=1;
                $comment->binhluan_id_phan_hoi=$data['reply_comment_id'];
                $comment->admin_id=$admin_id->id;
                $comment->khachhang_id=$data['reply_customer_id'];
                $comment->sanpham_id=$data['reply_product_id'];
                $comment->save();
            }else{
                $comment=new Comment();
                $comment->binhluan_ten_nguoi_danh_gia='Admin RGUWB';
                $comment->binhluan_noi_dung=$data['reply_admin_comment'];
                $comment->binhluan_ngay_danh_gia=$comment_date;
                $comment->binhluan_trang_thai=1;
                $comment->binhluan_id_phan_hoi=$data['reply_comment_id'];
                $comment->admin_id=$admin_id->id;
                $comment->sanpham_id=$data['reply_product_id'];
                $comment->save();
            }
            return redirect()->back()->with('message','Successfully Comment');
        }
    }

    public function DeleteComment($comment_id){
        $this->AuthLogin();
        $comment=Comment::find($comment_id);
        $comment->delete();
        $rep_comment=Comment::where('binhluan_id_phan_hoi',$comment_id)->delete();
        return redirect()->back()->with('message','Delete Success');
    }

}
