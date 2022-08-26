import { useCallback, useEffect, useState } from "react"
import DefaultLoader from "../../components/DefaultLoader"
import useAccountContext from "../../context/AccountContext/useAccountContext"
import AccountCardComponent from "../../Domains/Accounts/AccountCardComponent"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"
import useApi from "../../services/api/hooks/useApi"
import { Account } from "../../types/Account"

const AccountSelect = () => {

  const api = useApi()

  const { account: contextAccount, setAccount } = useAccountContext()

  const [loading, setLoading] = useState(false)
  const [accounts, setAccounts] = useState<Account[]>([])

  const load = useCallback(async () => {
    setAccounts([])
    setLoading(true)
    await api.get('accounts')
      .then(res => res.data)
      .then(setAccounts)
      .catch(console.log)
    setLoading(false)
  }, [api])


  const selectAccount = (a: Account) => {
    setAccount(undefined)
    setTimeout(() => {
      setAccount(a)
    }, 100)
  }

  useEffect(() => {
    load()
  }, [load])

  return (
    <div className="flex flex-col h-full justify-start items-center gap-4 p-8 w-full" >
      {
        loading &&
        <div className="w-full h-full flex items-center">
          <DefaultLoader />
        </div>
      }
      {
        accounts.map(account => (
          <AccountCardComponent
            key={account.id}
            account={account}
            onClick={selectAccount}
            highlight={account.id === contextAccount?.id}
          />
        ))
      }
    </div>
  )

}

export default AccountSelect