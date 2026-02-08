const form = document.getElementById("formulario");

form.addEventListener("submit", function (event) {
  event.preventDefault();

  const nome = document.getElementById("campo1").value.trim();
  const email = document.getElementById("campo2").value.trim();

  if (nome === "" || email === "") {
    alert("Preencha todos os campos!");
    return;
  }

  if (nome.length < 3) {
    alert("Nome deve ter pelo menos 3 caracteres!");
    return;
  }
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    alert("Email inválido! Use o formato: exemplo@dominio.com");
    return;
  }
  
  form.submit();
});
