<div x-data="aiInsight()" x-init="loadInsight()" class="bg-gradient-to-r from-indigo-600 to-indigo-800 p-5">
    <div class="flex items-start gap-3">
        <div class="mt-0.5 shrink-0 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-wand-magic-sparkles text-white text-sm"></i>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-1">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">AI Insight</h3>
                <button
                    x-show="!loading"
                    @click="loadInsight()"
                    class="text-xs text-white/70 hover:text-white transition-colors"
                    title="Refresh insight"
                >
                    <i class="fa-solid fa-rotate" :class="{ 'fa-spin': loading }"></i>
                </button>
            </div>

            <div x-show="loading" class="space-y-2 animate-pulse">
                <div class="h-3 bg-white/20 rounded w-full"></div>
                <div class="h-3 bg-white/20 rounded w-3/4"></div>
            </div>

            <p x-show="!loading && insight" x-text="insight" class="text-sm text-white/90 leading-relaxed"></p>

            <p x-show="!loading && !insight && !error" class="text-sm text-white/60">Memuat insight...</p>

            <p x-show="error" class="text-sm text-amber-200">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                <span x-text="error"></span>
            </p>
        </div>
    </div>
</div>

<script>
function aiInsight() {
    return {
        loading: false,
        insight: '',
        error: '',
        loadInsight() {
            this.loading = true;
            this.error = '';
            fetch('{{ route("ai.insight") }}')
                .then(r => r.json())
                .then(data => {
                    this.insight = data.insight;
                    this.loading = false;
                })
                .catch(e => {
                    this.error = 'Gagal memuat insight.';
                    this.loading = false;
                });
        }
    };
}
</script>
