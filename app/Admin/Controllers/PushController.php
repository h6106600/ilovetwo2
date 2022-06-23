<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Push;

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

        //$grid->column('id', __('ID'))->sortable();

        $grid->column('identity', __('會員名稱'))->sortable();
        $grid->column('pushes_user', __('排約會員'));
        $grid->column('pushes_user_new', __('要推播的會員'));
        $grid->column('pushes_user_latest', __('最新推播的會員'));
        $grid->column('pushes_user_excluded', __('排除的會員'));
  
        // $grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));

        $grid->filter(function($filter){

            $filter->disableIdFilter();
          

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

        //$form->display('id', __('ID'));
        if($form->isCreating()){
            $form->text('identity', __('會員名稱'));
        };
        if($form->isEditing()){
            $form->display('identity', __('會員名稱'));
        };

        $form->text('pushes_user', __('排約會員'))->help('輸入會員名稱，兩個以上需加頓號(、)當間隔，例 : sam、luke');
        $form->text('pushes_user_new', __('要推播的會員'))->help('輸入會員名稱，兩個以上需加頓號(、)當間隔，例 : sam、luke');
        $form->text('pushes_user_latest', __('最新推播的會員'))->help('輸入會員名稱，兩個以上需加頓號(、)當間隔，例 : sam、luke');
        $form->text('pushes_user_excluded', __('排除的會員'))->help('輸入會員名稱，兩個以上需加頓號(、)當間隔，例 : sam、luke');
      
        // $form->display('created_at', __('建立時間'));
        // $form->display('updated_at', __('更新時間'));
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
