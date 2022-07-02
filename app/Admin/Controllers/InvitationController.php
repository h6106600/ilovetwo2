<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Invitation;
use App\Models\DateData;
use App\Models\Restaurant;

class InvitationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '約會時間表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Invitation);
        $grid->column('id', __('ID'))->sortable();
        $grid->column('identity', __('會員名稱'))->display(function($data){

            $result = DateData::where('identity', $data)->pluck('username')->first();

            return $result;
        });
        $grid->column('invitation_identity', __('邀請對象'))->display(function($data){
            
            $result = DateData::where('identity', $data)->pluck('username')->first();

            return $result;
        });
        $grid->column('type', __('類型'));
        $grid->column('chat_option', __('聊天選項'));
        $grid->column('restaurant', __('餐廳'));
        $grid->column('datetime', __('排約時間'));
        $grid->column('respond', __('排約對象回應'));
        $grid->column('result', __('排約結果'));
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->where(function ($query) {
                $identity = DateData::where('username', $this->input)->pluck('identity')->first();    
                $query->whereIn('identity', [$identity]);
            }, '會員名稱');
        });

        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            //$actions->disableEdit();
            //$actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                //$batch->disableDelete();
            });
        });

        $html = <<<html
            <style>
                .pair_time{
                    background-color:orange;
                    padding:5px 10px; 
                    color:white;
                }
            </style>
        html;
        $grid->html($html);
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append("<a href='/date/pair_time' class='btn pair_time'>結果配對</a>");
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Invitation::findOrFail($id));

        //$show->field('id', __('ID'));
      
        $show->panel()
        ->tools(function ($tools) {
            // $tools->disableEdit();
            // $tools->disableList();
            // $tools->disableDelete();
        });
       
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Invitation);
        if($form->isCreating()){
            $form->text('identity', __('會員名稱'));
        };
        if($form->isEditing()){
            $form->display('identity', __('會員名稱'));
        };
        $form->text('invitation_identity', __('邀請對象'));
        $form->radio('type', __('類型'))->options(['餐廳約會' => '餐廳約會', '視訊約會'=> '視訊約會']);
        $form->radio('chat_option', __('聊天選項'))->options(['自由聊天' => '自由聊天', '選擇話題聊天'=> '選擇話題聊天', '破冰遊戲>聊天'=> '破冰遊戲>聊天']);
        $form->select('restaurant', __('餐廳'))->options(Restaurant::pluck('place')->toArray());
        $form->text('datetime', __('排約時間'));
        $form->text('respond', __('排約對象回應'));
        $form->text('result', __('排約結果'));
        
        $form->tools(function (Form\Tools $tools) {
            //$tools->disableList();
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        return $form;
    }
}
