import bs4 as bs
import urllib.request
import re
import sys
import json


if __name__ == "__main__":
	
	#CONCUTING URL AND ARGUMENT
	arg = sys.argv[1]
	url = "https://en.wikipedia.org/wiki/"
	url2 = url+arg

	#BEAUTIFUL SOUP STUFF
	source = urllib.request.urlopen(url2).read()
	soup = bs.BeautifulSoup(source,'lxml')

	#GETTING CONTENT OF THE TABLE ON THE RIGHT HAVING ALL THE INFO WE WANT
	table_cont = soup.find('table',class_='infobox geography vcard')


	#FLAG
	for tr in table_cont.findAll('tr'):
		if(re.search('Flag of',str(tr))):
			try:
				flag = re.search('(src="(.+?)")',str(tr)).group(2) 
			except AttributeError:
				flag='fail'
			break;

			
	#GETTING THE COUNTRY NAME
	country_name_cont = table_cont.find('span',class_='fn org country-name')
	try:
		country_name = re.search('<span class="fn org country-name">(.+?)</span>',str(country_name_cont)).group(1)
	except AttributeError:
		country_name ='fail'


	#GETTING CAPITAL NAME
	
	#THIS METHOD DIDNT WORK FOR MANY COUNTRIES
	##capital_name_cont = table_cont.findAll('a',href=re.compile('(/wiki/)+([A-Za-z0-9_:()])+'))
	##try:
	##    capital_name = re.search('<a href="/wiki/(.+?)" title="(.+?)">(.+?)</a>',str(capital_name_cont[11])).group(3)
	##except AttributeError:
	##    capital_name ='fail'

	for tr in table_cont.findAll('tr'):
		if(re.search('Capital',str(tr))):
			capital_name = re.search('<a href="/wiki/(.+?)" title="(.+?)">(.+?)</a>',str(tr)).group(3)

	#GETTING GEOLOCATION
	long_lang_cont = table_cont.find('span',class_='geo')

	try:
		lat = re.search('<span class="geo">(.+?);\s(.+?)</span>',str(long_lang_cont)).group(1)
		long = re.search('<span class="geo">(.+?);\s(.+?)</span>',str(long_lang_cont)).group(2)
	except AttributeError:
		lat ='fail'
		long = 'fail'

	#AREA
	for tr in table_cont.findAll('tr'):
		if(re.search('Total',str(tr))):
			try:
				area = re.search('[0-9]+,?[0-9]+,?[0-9]*',str(tr)).group(0)
			except AttributeError:
				area='fail'
			break;

	#POPULATION
	# for tr in table_cont.findAll('tr'):
		# if(re.search('estimate',str(tr))):
			# try:
				# pop = re.search('[0-9]+,[0-9]+,?[0-9]*',str(tr)).group(0)
			# except AttributeError:
				# pop='fail'
			# break;

	#POPULATION
	temp = 0;
	for tr in table_cont.findAll('tr'):
		if (temp == 1):
			try:
				pop = re.search('[0-9]+,[0-9]+,?[0-9]*',str(tr)).group(0)
			except AttributeError:
				pop='fail'
			break;
		if(re.search('Population',str(tr))):
			temp = 1;
			
	
	
	#GDP
	for tr in table_cont.findAll('tr'):
		if(re.search('Per capita',str(tr))):
			try:
				gdp = re.search('[0-9]+,[0-9]+,?[0-9]*',str(tr)).group(0)
			except AttributeError:
				gdp='fail'
			break;

	#HDI
	for tr in table_cont.findAll('tr'):
		if(re.search('HDI',str(tr))):
			try:
				hdi = re.search('([0-9]+\.[0-9]+(?!x))',str(tr)).group(0) #αριθμος+ τελεια αριθμος+ (negative lookahead αν περιεχει x το προσπερναει)
			except AttributeError:
				hdi='fail'
			break;

	#GINI
	for tr in table_cont.findAll('tr'):
		if(re.search('Gini',str(tr))):
			try:
				gini = re.search('([0-9]+\.[0-9]+(?!x))',str(tr)).group(0) 
			except AttributeError:
				gini='fail'
			break;
	
	#PRINTING FETCHED DATA FOR THE OUTPUT ARRAY ,OF THE EXEC COMMAND, TO CATCH
	print(flag)
	print(country_name)
	print(capital_name)
	print(lat)
	print(long)
	print(area)
	print(pop)
	print(gdp)
	print(hdi)
	print(gini)
	






