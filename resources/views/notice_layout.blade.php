@foreach ($noticeDataArray as $noticeData)
    <div class="notice" id="notice_link_{{ $loop->index }}">
        @if ($noticeData->isTodoNotice())
            <div class="is_todo_notice">やること</div>
        @else
            <div class="is_project_notic">プロジェクト</div>
        @endif
        <div class="name">{{ $noticeData->getMessage() }}</div>
        <script>
            $('#notice_link_{{ $loop->index }}').click(function () {
                window.location.href = "{{ $noticeData->getLink() }}";
            });
        </script>
    </div> 
@endforeach