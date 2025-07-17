<footer class="footer mt-4 px-4">
    <div>
        @if (setting("show_copyright"))
            <small>
                @lang("Copyright")
                &copy; {{ date("Y") }}
            </small>
        @endif
    </div>
</footer>
