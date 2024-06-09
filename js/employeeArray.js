const FullNameArray = [];

// Pobierz dane z bazy danych za pomocą AJAX lub fetch API
fetch('db.php')
  .then(response => response.json())
  .then(data => {
    data.forEach(employee => {
      const fullName = `${employee.imie} ${employee.nazwisko} - ${employee.position.nazwa}`;
      FullNameArray.push(fullName);
    });
  });

function foundEmployee(str) {
  const FoundArray = [];
  for (let i = 0; i < FullNameArray.length; i++) {
    if (FullNameArray[i].toLowerCase().includes(str.toLowerCase())) {
      FoundArray.push(FullNameArray[i]);
    }
  }
  return FoundArray;
}