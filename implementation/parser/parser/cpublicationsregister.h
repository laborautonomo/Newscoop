/******************************************************************************

CAMPSITE is a Unicode-enabled multilingual web content
management system for news publications.
CAMPFIRE is a Unicode-enabled java-based near WYSIWYG text editor.
Copyright (C)2000,2001  Media Development Loan Fund
contact: contact@campware.org - http://www.campware.org
Campware encourages further development. Please let us know.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

******************************************************************************/


#ifndef CPUBLICATIONSREGISTER_H
#define CPUBLICATIONSREGISTER_H


#include <string>
#include <map>


using std::string;
using std::map;
using std::less;

class CPublication;

typedef map <long, CPublication*, less<long> > CPublicationsMap;
typedef map <string, long, less<string> > CPublicationsAliases;


/**
  * class CPublicationsRegister
  * store publications metadata classes; for retrieving the CURLType based on the
  * site name; static class
  */

class CPublicationsRegister
{
public:
	CPublicationsRegister() {}

	static CPublicationsRegister& getInstance();

	void insert(CPublication& p_rcoPublication);

	void erase(long p_nPublicationId);

	bool has(long p_nPublicationId) const;

	const CPublication* getPublication(const string& p_rcoAlias) const;

private:
	CPublicationsMap m_coPublications;
	CPublicationsAliases m_coAliases;

#ifdef _REENTRANT
	mutable CMutex m_coMutex;
#endif
};


// global CPublicationsRegister instance used to store all publication objects
extern CPublicationsRegister g_coPublicationsRegister;


// CPublicationsRegister inline methods

inline CPublicationsRegister& CPublicationsRegister::getInstance()
{
	return g_coPublicationsRegister;
}

inline void CPublicationsRegister::erase(long p_nPublicationId)
{
#ifdef _REENTRANT
	CMutexHandler coLockHandler(&m_coMutex);
#endif
	m_coPublications.erase(p_nPublicationId);
}

inline bool CPublicationsRegister::has(long p_nPublicationId) const
{
#ifdef _REENTRANT
	CMutexHandler coLockHandler(&m_coMutex);
#endif
	return m_coPublications.find(p_nPublicationId) != m_coPublications.end();
}

inline const CPublication* CPublicationsRegister::getPublication(const string& p_rcoAlias) const
{
#ifdef _REENTRANT
	CMutexHandler coLockHandler(&m_coMutex);
#endif
	CPublicationsAliases::const_iterator coIt = m_coAliases.find(p_rcoAlias);
	if (coIt != m_coAliases.end())
	{
		CPublicationsMap::const_iterator coIt2 = m_coPublications.find((*coIt).second);
		if (coIt2 != m_coPublications.end())
			return (*coIt2).second;
	}
	return NULL;
}


#endif // CPUBLICATIONSREGISTER_H
