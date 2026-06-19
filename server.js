app.post('/register', (req, res) => {
  const { name, email, password, gender } = req.body;
  console.log(`Registered: ${name}, ${email}, ${gender}`);
  res.redirect('/discount.html');
});