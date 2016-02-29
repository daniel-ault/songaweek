import sys
import re

def main():
	print sys.argv[0]
	print sys.argv[1]
	
	match = re.match(r'^[0-9]+$', sys.argv[1])

	if match == None:
		print "None"
	else:
		print "Valid!"
	

main()
