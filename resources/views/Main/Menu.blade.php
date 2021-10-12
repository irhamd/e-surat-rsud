<ul class="sidebar-menu" data-widget="tree">
    <li class="header" style="color:white">Menu Utama</li>
    <li>
        <a href="/home">
            <i class="fa fa-home"></i> Branda <span></span>
        </a>
        </span>
    </li>
    <li>
        <a href="/disposisi">
            <i class="fa fa-share-alt"></i>Disposisi  
            <span class="pull-right-container">
                @if (Session::get("jlhDisposisi") > 0)
                <small class="label pull-right bg-yellow">
                    {{ Session::get("jlhDisposisi") }}

                </small>
                @endif
            </span>
        </a>
        </span>
    </li>

    

    <li>
        <a href="/InboxRev">
            <i class="fa fa-envelope"></i>Inbox <span></span>
            <span class="pull-right-container">
                @if (Session::get("getInbox") > 0)
                <small class="label pull-right bg-yellow">
                    {{ Session::get("getInbox") }}

                </small>
                @endif
            </span>
        </a>
        </span>
    </li>


    <li>
        <a href="/buatSurat">
            <i class="fa fa-file-text-o"></i> Buat Surat <span></span>
        </a>
    </li>


    <li>
        <a href="/arsipSurat">
            <i class="fa fa-folder-open"></i> Arsip Surat <span></span>
        </a>
    </li>

    <li>
        <a href="/requestParaf">
            <i class="fa fa-pencil-square-o"></i> Request Paraf <span></span>
            <span class="pull-right-container">
                @if (Session::get("jlhparaf") > 0)
                <small class="label pull-right bg-yellow">
                    {{ Session::get("jlhparaf") }}

                </small>
                @endif

            </span>
        </a>
    </li>

    <li>
        <a href="/requestttd">
            <i class="fa fa-pencil-square"></i> Request Tanda Tangan <span></span>
            <span class="pull-right-container">
                @if (Session::get("jlhTTD") > 0)
                <small class="label pull-right bg-yellow">
                    {{ Session::get("jlhTTD") }}
                </small>
                @endif
                {{-- @if (Session::get("totalTTD") > 0)
                    <small class="label pull-right bg-blue">
                        {{ Session::get("totalTTD") }}
                </small>
                @endif --}}
            </span>
        </a>
    </li>
    <li>
        <a href="/Outbox">
            <i class="fa fa-share-square-o"></i> Outbox <span></span>
            <span class="pull-right-container">
                @if (Session::get("getRevisi") > 0)
                <small class="label pull-right bg-yellow">
                    {{ Session::get("getRevisi") }}
                </small>
                @endif

                @if (Session::get("getReject") > 0)
                <small class="label pull-right bg-red">
                    {{ Session::get("getReject") }}
                </small>
                @endif

                @if (Session::get("getApprove") > 0)
                <small class="label pull-right bg-green">
                    {{ Session::get("getApprove") }}
                </small>
                @endif
            </span>
        </a>
    </li>
    <li>
        <a href="/">
            <i class="fa fa-book"></i> Log Book Surat <span></span>

        </a>
    </li>

    <li>
        <a href="/suratExternalRev">
            <i class="fa fa-file-text-o"></i> Surat External <span></span>
            {{-- <span class="pull-right-container">
                <small class="label pull-right bg-yellow">0</small>
                <small class="label pull-right bg-blue">0</small>
            </span> --}}
        </a>
    </li>

    <li class="header">Guest</li>

    <li>
        <a href="/logouta">
            <i class="fa fa-lock"></i>
            <span>Logout</span></a>
    </li>
    {{-- <li>
        <a href="#exGantiPassword" rel="modal:open" id="show">
            <i class="fa fa-gear"></i>
            <span>Ganti Password</span></a>
    </li> --}}
</ul>
