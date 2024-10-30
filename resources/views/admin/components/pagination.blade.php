@if ($paginator->hasPages())
    @php
        $linksOnEachSlide = 3;
        $halfLinksOnEachSlide = ($linksOnEachSlide - 1) / 2;
        $startPage = $paginator->currentPage() - $halfLinksOnEachSlide < 1 ? 1 : ($paginator->currentPage() - $halfLinksOnEachSlide);
        $endPage = ($paginator->currentPage() + $halfLinksOnEachSlide) > $paginator->lastPage() ? $paginator->lastPage() : ($paginator->currentPage() + $halfLinksOnEachSlide);
        $endPage = $endPage < $linksOnEachSlide ? $linksOnEachSlide : $endPage;
        $startPage = $endPage - $linksOnEachSlide < $startPage ? $endPage - ($halfLinksOnEachSlide * 2) : $startPage;

        $urlFirstPage = request()->getRequestUri();
        $query = request()->query();

        $urlWithoutParams = explode('?', $urlFirstPage)[0];
    @endphp

    <div class="pager">
        <ul class="pagination pagination-sm m-0 float-right">
            @if ($paginator->onFirstPage() || $paginator->lastPage() <= 1)
                <li class="page-item"><a class="page-link disabled">«</a></li>
            @else
                @php
                    if($paginator->currentPage()-1 == 1){
                        $query['page'] = null;
                    } else {
                        $query['page'] = $paginator->currentPage()-1;
                    }
                @endphp
                <li class="page-item"><a class="page-link"
                                         href="{{ $urlWithoutParams . '?' . http_build_query($query,'','&') }}">«</a>
                </li>
            @endif

            @foreach($elements as $element)
                @foreach($element as $page=>$url)
                    @if($paginator->currentPage() == $page)
                        <li class="page-item"><a class="page-link active">{{ $page }}</a></li>
                    @else
                        @php
                        if($page == 1){
                            $query['page'] = null;
                        } else{
                            $query['page'] = $page;
                        }
                        @endphp
                        <li class="page-item"><a class="page-link"
                                                 href="{{ $urlWithoutParams . '?' . http_build_query($query,'','&') }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endforeach

            @if ($paginator->hasMorePages())
                @php
                    $query['page'] = $paginator->currentPage()+ 1;
                @endphp
                <li class="page-item"><a class="page-link"
                                         href="{{ $urlWithoutParams . '?' . http_build_query($query,'','&') }}">»</a>
                </li>
            @else
                <li class="page-item"><a class="page-link disabled">»</a></li>
            @endif

        </ul>
    </div>
@endif
