<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Invitation;

class InvitationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '排約邀約表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Invitation);

        $grid->column('identity', __('身分證'));
        $grid->column('type', __('類型'));
        $grid->column('chat_option', __('聊天選項'));
        $grid->column('restaurant', __('餐廳'));
        $grid->column('datetime', __('時段'));

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

        $form->text('identity', __('身分證'));
        $form->text('type', __('類型'));
        $form->text('chat_option', __('聊天選項'));
        $form->text('restaurant', __('餐廳'));
        $form->text('datetime', __('時段'));

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
