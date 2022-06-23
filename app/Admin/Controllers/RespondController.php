<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Respond;

class RespondController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '排約回應表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Respond);

        //$grid->column('id', __('ID'))->sortable();
        $grid->column('invitation_id', __('邀請表ID'));
        $grid->column('respond', __('回應'));

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
        $show = new Show(Respond::findOrFail($id));

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
        $form = new Form(new Respond);

        //$form->display('id', __('ID'));
        $form->display('invitation_id', __('邀請表ID'));
        $form->text('respond', __('回應'));

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
