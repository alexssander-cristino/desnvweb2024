// Função para adicionar caracteres ao visor
function appendcaracther(character) {
    const display = document.getElementById('display');
    display.value += character;
}

// Função para calcular o resultado
function calculatorresult() {
    const display = document.getElementById('display');
    try {
        // Avalia a expressão matemática no visor
        display.value = eval(display.value);
    } catch (error) {
        // Em caso de erro, mostra uma mensagem no visor
        display.value = 'Erro';
    }
}

// Função para limpar o visor
function clearDisplay() {
    const display = document.getElementById('display');
    display.value = '';
}

// Função para deletar o último caractere
function deletelast() {
    const display = document.getElementById('display');
    display.value = display.value.slice(0, -1);
}