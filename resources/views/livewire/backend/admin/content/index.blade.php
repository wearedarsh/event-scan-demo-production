<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Content for {{ $event->title }}</h2>
    </div>

    @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <span class="font-m">{{ $errors->first() }}</span>           
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <span class="font-m">{{ session('success') }}</span>           
                </div>
            </div>
        </div>
    @endif

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{$event->title}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Content</li>
            </ol>
        </nav>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h3>Event content</h3>
            </div>
            <div class="col-sm-3">
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{ route('admin.events.content.create', ['event' => $event->id]) }}"><span class="cil-plus me-1"></span>Add Event Content</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m">
                <thead class="table-light">
                    <tr>
                        <th>Content title</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->contentAll as $content)
                        <tr>
                            <td>{{ $content->title }}</td>
                            <td>
                                {{$content->order}}
                            </td>
                            <td>
                                @if($content->active)
                                    <span class="badge text-bg-success font-s fw-normal"><span class="text-brand-light">Active</span></span>
                                @else
                                    <span class="badge text-bg-danger font-s fw-normal"><span class="text-brand-light">Inactive</span></span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item font-m" href="{{route('admin.events.content.edit', ['event' => $event->id, 'content' => $content->id])}}">Edit</a></li>
                                        <li><a class="dropdown-item font-m cursor-pointer" wire:confirm="Are you sure you want to delete this content?" wire:click.prevent="delete({{$content->id}})">Delete</a></li> 
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No content found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h3>Event Downloads</h3>
            </div>
            <div class="col-sm-3">
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{route('admin.events.downloads.create', ['event' => $event->id])}}"><span class="cil-plus me-1"></span>Add Event Download</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m">
                <thead class="table-light">
                    <tr>
                        <th>Download title</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($downloads as $download)
                        <tr>
                            <td>{{ $download->title }}</td>
                            <td>{{ $download->display_order }}</td>
                            <td>
                                @if($download->active)
                                    <span class="badge text-bg-success font-s fw-normal"><span class="text-brand-light">Active</span></span>
                                @else
                                    <span class="badge text-bg-danger font-s fw-normal"><span class="text-brand-light">Inactive</span></span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item font-m" href="{{ route('admin.events.downloads.edit', ['event' => $event->id, 'download' => $download->id]) }}">Edit</a></li>
                                        <li><a class="dropdown-item font-m cursor-pointer" wire:confirm="Are you sure you want to delete this download?" wire:click.prevent="deleteDownload({{ $download->id }})">Delete</a></li> 
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No downloads found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    
