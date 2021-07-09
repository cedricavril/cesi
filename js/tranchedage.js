var age = parseInt(prompt('Saisir un age'));
if(age <= 17) alert('Pas encore majeur !');
else if(age <= 49) alert('Majeur mais pas senior !');
else if(age <= 59) alert('Senior !');
else if(age <= 120) alert('Retraité ou mort !');
