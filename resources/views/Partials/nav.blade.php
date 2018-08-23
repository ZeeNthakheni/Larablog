
    <nav class="navbar navbar-laravel navbar-light navbar-expand-md">
            <div class="container-fluid"><a href="/" class="navbar-brand">{{config('app.name','LSAPP')}}</a>
                <button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse"
                    id="navcol-1">
                    <ul class="nav navbar-nav mx-auto">
                            <li role="presentation" class="nav-item"><a href="/" class="nav-link active">Home</a></li>
                            <li role="presentation" class="nav-item"><a href="/about" class="nav-link active">About</a></li>
                            <li role="presentation" class="nav-item"><a href="/services" class="nav-link active">Services</a></li>
                            <li role="presentation" class="nav-item"><a href="/posts" class="nav-link active">Blog</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation" class="nav-item"><a href="/posts/create" class="nav-link active">Create Post</a></li>
                    </ul>
                </div>
            </div>
        </nav>

  