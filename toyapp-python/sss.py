import random

def f(a,x,q):
	 sum = 0;
	 for i in xrange(0,len(a)):
	 	sum = (sum + (a[i]*((x**i)%q))%q)%q
	 return sum%q

def deal(n,k,p,s):
	q = p
	a = list()
	a = [s]
	n = int(n)
	k = int(k)
	for i in xrange(1,k):
		a.append(random.randrange(0,q-1))
	shares = list()
	for i in xrange(1,n+1):
		shares.append([i,(f(a,i,q)%q)])
	return shares


def gcd(a,b):
	if b==0:
		return a
	return gcd(b,a%b)

def extendedEuclid(a,b):
	if b==0:
		return (a,1,0)

	tuplPrime = extendedEuclid(b,a % b)
	return [tuplPrime[0], tuplPrime[2], (tuplPrime[1] - (a//b)*tuplPrime[2])]
	
def reconstruct(p,shares):
	q = p
	s = 0;
	for share in shares:
		LBPn = 1
		LBPd = 1
		for iterShare in shares:
			if iterShare == share:
				continue
			LBPn = (LBPn * iterShare[0])%q
			LBPd = (LBPd * (iterShare[0] - share[0]))%q # -1 of numerator adjusted with denominator
		d = gcd(LBPn, LBPd)
		LBPd = LBPd//d
		LBPn = LBPn//d
		inverse = (extendedEuclid(LBPd,q)[1])
		LBPn = (LBPn*inverse)%q
		s = (s+(share[1]*LBPn))%q
	return s