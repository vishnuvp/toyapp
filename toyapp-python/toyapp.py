#!/usr/bin/env python

import sss
import aes
import random
import sys
import json
def generate_secrets(file_name, n, k):
	_16byteNo_start = 1000000000000000
	_16byteNo_end   = 9999999999999999
	key = random.randrange(_16byteNo_start,_16byteNo_end)
	aes.encrypt_file(str(key),file_name)
	prime  = 18895749970915969007
	secret = key#int("1234567890123456")
	shares = sss.deal(n,k,prime,secret)
	return shares

def reconstruct(file_name,shares):
	prime  = 18895749970915969007
	key = sss.reconstruct(prime,shares)
	#print key
	return aes.decrypt_file(str(key),file_name)

if sys.argv[1] == 'encrypt':
	shares = generate_secrets(sys.argv[2], int(sys.argv[3]), int(sys.argv[4]))
	print json.dumps(shares)

if sys.argv[1] == 'decrypt':
	shares = json.loads(sys.argv[3])
	print reconstruct(sys.argv[2], shares).split('/')[-1]
