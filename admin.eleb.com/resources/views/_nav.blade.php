<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid" style="background-color: #9dcbff">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                {{--<form class="navbar-form navbar-left">--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" class="form-control" placeholder="Search">--}}
                    {{--</div>--}}
                    {{--<button type="submit" class="btn btn-default">Submit</button>--}}
                {{--</form>--}}

                @auth
                <ul class="nav navbar-nav navbar-right">
                    <?php
//                    $childs = \App\Models\Cd::where('pid',1)->where('id','<>',1)->get();
//                    foreach($childs as $child){
//                        var_dump($child);
//                        foreach(\App\Models\Cd::where('pid',$child->id)->get() as $v){
////                            var_dump($v);
//                        }
//                    }
                    ?>
                    {{--{!! \App\Models\Cd::getChildHtml() !!}--}}

                    {{--@role('用户管理员')--}}
                    @foreach(\App\Models\Cd::where('pid',1)->where('id','<>',1)->get() as $child)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><button class="btn btn-primary">{{ $child->name }}</button><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Models\Cd::where('pid',$child->id)->get() as $v)
                                <li><a href="{{ route($v->url) }}">{{ $v->name }}</a></li>
                            @endforeach
                            {{--<li><a href="{{ route('users.create') }}">添加用户</a></li>--}}
                        </ul>
                    </li>
                    @endforeach
                    {{--@endrole--}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><button class="btn btn-warning">{{ Auth::user()->name }}</button><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            {{--<li><a href="{{ route('admins.form') }}">修改密码</a></li>--}}
                            @role('超级管理员')
                            <li><a href="{{ route('admins.index') }}">管理员列表</a></li>
                            <li><a href="{{ route('permissions.index') }}">权限列表</a></li>
                            <li><a href="{{ route('roles.index') }}">角色列表</a></li>
                            @endrole
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-primary">注销</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endauth
                @guest
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('login') }}">登录</a></li>
                </ul>
                @endguest
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>

