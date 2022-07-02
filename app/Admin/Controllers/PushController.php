<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\DateData;
use App\Models\Push;
use App\Admin\Actions\Push\AddMember;
use App\Admin\Actions\Push\PushMember;
use App\Admin\Actions\Push\BackMember;

class PushController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '會員推播表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Push);

        $grid->column('identity', __('會員名稱'))->display(function($data){
            $result = DateData::where('identity', $data)->pluck('username')->first();

            return $result;
        });
        $grid->column('pushes_user', __('排約會員'))->display(function($data){
            $ary = explode('、', $data);
            $result = DateData::whereIn('identity', $ary)->pluck('username')->toArray();
            $result = implode("、", $result);
            return $result;
        });
        $grid->column('pushes_user_new', __('要推播的會員'))->display(function($data){
            $ary = explode('、', $data);
            $result = DateData::whereIn('identity', $ary)->pluck('username')->toArray();
            $result = implode("、", $result);
            return $result;
        });
        // $grid->column('pushes_user_latest', __('最新推播的會員'))->display(function($data){
        //     $ary = explode('、', $data);
        //     $result = DateData::whereIn('identity', $ary)->pluck('username')->toArray();
        //     $result = implode("、", $result);
        //     return $result;
        // });
        $grid->column('pushes_user_excluded', __('排除的會員'))->display(function($data){
            $ary = explode('、', $data);
            $result = DateData::whereIn('identity', $ary)->pluck('username')->toArray();
            $result = implode("、", $result);
            return $result;
        });

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
            $actions->disableView();//取消顯示
            //$actions->disableEdit();//取消編輯
            //$actions->disableDelete();//取消刪除
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                //$batch->disableDelete();//取消批次刪除 
            });
        });

        $grid->batchActions(function ($batch) { 
            $batch->add(new AddMember());
            $batch->add(new PushMember());
            $batch->add(new BackMember());
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
        $show = new Show(Push::findOrFail($id));

        //$show->field('id', __('ID'));

        $show->panel()
        ->tools(function ($tools) {
            // $tools->disableEdit();
            // $tools->disableList();
            // $tools->disableDelete();
        });;
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Push);

        if($form->isCreating()){
            $form->select('identity', __('會員名稱'))->options(DateData::pluck('username','identity')->toArray());
        };
        if($form->isEditing()){
            $form->select('identity', __('會員名稱'))->options(DateData::pluck('username','identity')->toArray())->readonly();
        };

        $form->text('pushes_user', __('排約會員'));
        $form->text('pushes_user_new', __('要推播的會員'));
        //$form->text('pushes_user_latest', __('最新推播的會員'));
        $form->text('pushes_user_excluded', __('排除的會員'));
      
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
