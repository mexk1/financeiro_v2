import { Account } from "../../types/Account"

const AccountCardComponent = ( { account, onClick }:Props ) => {

  const handleClick = () => {
    onClick && onClick( account )
  }

  return (
    <div className="bg-white rounded-md shadow-md shadow-indigo-400 text-black w-full mx-4 flex items-center justify-center" onClick={ handleClick } >
      { account.name }
    </div>
  )
}

interface Props { 
  account: Account,
  onClick?: ( a:Account ) => void 
}

export default AccountCardComponent