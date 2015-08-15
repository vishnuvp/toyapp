import math
def gcd(a,b):
	#print 'gcd(',a,b,')'
	if b==0:
		#print 'returning'
		return a
	return gcd(b,a%b)

def extendedEuclid(a,b):
	if b==0:
		return (a,1,0)
		#print '%3d %3d %3d %3d %3d %3d' % (a,b,a//b, a,1,0)

	tuplPrime = extendedEuclid(b,a % b)
	#print '%3d %3d %3d %3d %3d %3d' % (a,b,a//b, tuplPrime[0],tuplPrime[1], tuplPrime[2])

	return [tuplPrime[0], tuplPrime[2], (tuplPrime[1] - (a//b)*tuplPrime[2])]
	
def reconstruct(p,shares):

	#p = 13#13242953281603340610789922133094055797390558061272099255674488170466718789312363580069278175009125400689444794425077294554199088932662391320617201210642869L
	q = p

	# NoOfShares = int(raw_input("Enter no of shares:"))
	# shares = []
	# for i in xrange(0,NoOfShares):
	# 	print 'Enter share ', i+1
	# 	shares.append([int(raw_input("x:")),int(raw_input("y:"))]);
	# print shares
	#shares = [[1, 4], [2, 6], [3, 1]]#[[1, 11729551539016081955022093387099355520552915771417716873371398372293686183701203556801457446369314509670100722872825740085103204781696146679771164742424044], [2, 8531774621418519289052387928525403163279655828986381126529955114799297316101321219013273549305624770236474874901721067568760540454299120848060014424737464], [3, 5385816056428709525969604135494075799545058565544500054300369189569125606689276538661422436283336823749253031668372749003225104492590087503270539104624646]]
	#L = []
	s = 0;
	for share in shares:
		LBPn = 1
		LBPd = 1
		for iterShare in shares:
			if iterShare == share:
				#print iterShare, share, 'skipping' 
				continue
			#print iterShare, share
			LBPn = (LBPn * iterShare[0])%q
			LBPd = (LBPd * (iterShare[0] - share[0]))%q # -1 of numerator adjusted with denominator
		#print LBPd, LBPn
		d = gcd(LBPn, LBPd)
		print d
		LBPd = LBPd//d
		LBPn = LBPn//d
		#print d,LBPd, LBPn
		inverse = (extendedEuclid(LBPd,q)[1])
		LBPn = (LBPn*inverse)%q
		s = (s+(share[1]*LBPn))%q
	#print s	
	#s %= q
	#print s
	return s
	#10*3' mod 22
