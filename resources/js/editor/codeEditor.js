import * as monaco from 'monaco-editor';

window.initCodeEditor = function () {
    const el = document.getElementById('editor');
    if (!el) return;

    const input = document.getElementById('code_output');

    // ✅ FIX WORKER ERROR
    self.MonacoEnvironment = {
        getWorker: function () {
            return new Worker(
                URL.createObjectURL(
                    new Blob(['self.onmessage = () => {}'], { type: 'text/javascript' })
                )
            );
        }
    };

    const editor = monaco.editor.create(el, {
        value: "// Start typing here...\n",
        language: "javascript",
        theme: "vs-dark",
        automaticLayout: true,
        readOnly: false,
        minimap: { enabled: false },
    });

    editor.focus();

    editor.onDidChangeModelContent(() => {
        if (input) input.value = editor.getValue();
    });

    if (input) input.value = editor.getValue();
};
