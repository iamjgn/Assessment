function changeColor()
{
	const hexvalues = "0123456789ABCDEF";
	let color = "#";
	for(let i = 0; i < 6; i++)
	{
		color += hexvalues[Math.floor(Math.random() * 16)];
	}
	document.getElementsByTagName("body")[0].style.backgroundColor = color;
}
