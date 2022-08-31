import { useCallback, useEffect, useState } from "react"
import DefaultLoader from "../../components/DefaultLoader"
import Modal from "../../components/Modal"
import useShouldHaveAccountSelected from "../../context/AccountContext/useShouldHaveAccountSelected"
import BankAccountCardComponent from "../../Domains/BankAccounts/BankAccountCardComponent"
import BankAccountForm from "../../Domains/BankAccounts/BankAccountForm"
import useModalControls from "../../hooks/useModalControls"
import useApi from "../../services/api/hooks/useApi"
import { BankAccount } from "../../types/BankAccount"

const BankAccounts = () => {

  const api = useApi()
  const account = useShouldHaveAccountSelected()

  const [selectedBankAccount, setSelectedBankAccount] = useState<BankAccount>()

  const [loading, setLoading] = useState(false)
  const [bankAccounts, setBankAccounts] = useState<BankAccount[]>([])

  const { open, close, isOpen } = useModalControls()

  const load = useCallback(async () => {
    setBankAccounts([])
    setLoading(true)
    account && await api.get( `accounts/${account.id}/bank-accounts`)
      .then(res => res.data)
      .then(setBankAccounts)
      .catch(console.log)
    setLoading(false)
  }, [api])

  const handleUpdate = () => {
    setSelectedBankAccount(undefined)
    close()
    load()
  }

  const selectForUpdate = (a: BankAccount) => {
    setSelectedBankAccount(undefined)
    close()
    setTimeout(() => {
      open()
      setSelectedBankAccount(a)
    }, 100)
  }

  const Form = useCallback(() => (
    <BankAccountForm
      onSuccess={handleUpdate}
      bankAccount={selectedBankAccount}
    />
  ), [selectedBankAccount])

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
        bankAccounts.map(bankAccount => (
          <BankAccountCardComponent
            key={bankAccount.id}
            bankAccount={bankAccount}
            onClick={selectForUpdate}
          />
        ))
      }
      <div className="text-black">
        <Modal
          trigger={props => (<>
            {
              !loading &&
              <button
                {...props}
                className={"text-white" + (props?.className ?? '')}
                onClick={e => {
                  setSelectedBankAccount(undefined)
                  props?.onClick && props.onClick(e)
                }
                }
              >
                Adicionar nova
              </button>
            }
          </>
          )}
          isOpen={isOpen}
          onOpen={open}
          onClose={close}
          children={<Form />}
        />
      </div>
    </div>

  )

}

export default BankAccounts