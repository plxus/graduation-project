@extends('layouts.default')

@section('title', '关于')

@section('content')
  <div class="container">
    <h1>关于</h1>
    <div class="row">
      <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked" role="tablist">
          <li role="presentation" class="active"><a href="#project" aria-controls="project" role="tab" data-toggle="pill">项目简介</a></li>
          <li role="presentation"><a href="#developer" aria-controls="developer" role="tab" data-toggle="pill">开发者</a></li>
          <li role="presentation"><a href="#feedback" aria-controls="feedback" role="tab" data-toggle="pill">反馈</a></li>
        </ul>
      </div>

      <div class="col-md-8 col-md-offset-1">
        <div class="tab-content">
          {{-- 项目简介 --}}
          <div role="tabpanel" class="tab-pane fade in active" id="project">
            <h3 class="top-h">知所</h3>
            <p>
              一个面向大学生的知识清单管理系统。
            </p>
            <h4>目的与意义</h4>
            <p>
              知识清单管理系统的设计与实现一方面能够帮助高校大学生实现以知识为核心的个人信息资源的有序整理与集中归档，让过去通过纸笔记录等传统方式实现的知识管理能够被更加高效率的信息化方式取代。
            </p>
            <p>
              另一方面，人们能够在该平台上与他人分享自己积累的知识、经验和技能，也能轻松查阅浏览到自己感兴趣的领域中由他人共享的知识清单，让知识得以在人际共享和流通中创造出更大的价值和意义。
            </p>
            <h4>技术架构</h4>
            <p>
              前端：
              <ul>
                <li>jQuery</li>
                <li>Bootstrap</li>
              </ul>
            </p>
            <p>
              后端：
              <ul>
                <li>Laravel 框架</li>
                <li>MySQL 数据库</li>
                <li>MAMP 集成开发环境</li>
              </ul>
            </p>
          </div>

          {{-- 开发者 --}}
          <div role="tabpanel" class="tab-pane fade" id="developer">
            <h3 class="top-h">徐嘉昊</h3>
            <p>
              2014 级南开大学商学院信息管理与信息系统专业。
              <br />
              E-Mail：xplusxu@gmail.com
            </p>
            <br />
            <h3>徐梦龙</h3>
            <p>
              2014 级南开大学商学院电子商务。
            </p>
          </div>

          {{-- 反馈 --}}
          <div role="tabpanel" class="tab-pane fade" id="feedback">
            <p>
              如有任何 bug 反馈或改进建议，欢迎发送电子邮件至 <a href="mailto:xplusxu@gmail.com">xplusxu@gmail.com</a> 。
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
